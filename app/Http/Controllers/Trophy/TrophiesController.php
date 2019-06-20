<?php

namespace App\Http\Controllers\Trophy;

use App\Http\Controllers\Controller;
use App\Models\Cms\CmsUser;
use App\Models\Cms\TrophyCupConfig;
use App\Models\Cms\TrophyHistory;
use App\Models\User\User;
use App\Models\User\UserNews;
use App\Traits\PetIdConvertTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class TrophiesController
 */
class TrophiesController extends Controller
{
    use PetIdConvertTrait;

    /**
     * Show the trophy cup form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = CmsUser::with('cmsRoles')->whereId(auth()->id())->first();
        if (!in_array(CmsUser::ADMIN, array_column($user->cmsRoles->toArray(), 'id'))) {
            if (empty($request->get('environment'))) {
                session()->put('environment', 'live');
            }
        }

        $user_id = auth()->id();
        $auth = CmsUser::where(['id' => $user_id])->first();
        $asset_quote = TrophyCupConfig::with('assetId')->where(['user_id' => $user_id])->first();

        return view('trophies.index', [
            'user_id'           => $user_id,
            'asset_quote'       => $asset_quote,
            'trophy_cups_count' => $auth['gift_count'],
        ]);
    }

    /**
     * Find user
     *
     * @param Request $request Request
     *
     * @return array
     */
    public function findUser(Request $request)
    {
        if (empty($request->get('uid'))) {
            $users = User::with('userPets')->whereRaw("concat(first_name, ' ', last_name) like '%" . trim($request->get('name')) . "%' ")->get();
        } else {
            $uid = $request->get('uid');
            if (!ctype_digit($request->get('uid'))) {
                $uid = $this->decode($request->get('uid'));
            }
            $users = User::with('userPets')->where(['id' => $uid])->get();
        }

        foreach ($users as $k => $user) {
            $users[$k]['pet'] = $user->userPets->first();
        }

        return [
            'users' => $users,
            'type'  => $request->get('prefix')
        ];
    }

    /**
     * Send gift
     *
     * @param Request $request Request
     *
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function send(Request $request)
    {
        $requestData = $request->all();
        $user_id = auth()->id();
        $message_list = $this->trophyValidate($user_id, $requestData['cup_data']);

        if (!empty($message_list)) {
            return ['errors' => $message_list];
        }

        $news = UserNews::create([
            'user_id'         => $requestData['cup_data']['sender_uid'],
            'interlocutor_id' => $requestData['cup_data']['receiver_uid'],
            'direction'       => UserNews::DIRECTION_FROM_ME,
            'type'            => UserNews::NEWS_TYPE_GIFT_TYPE,
            'status'          => UserNews::STATUS_NEW,
            'message'         => $requestData['cup_data']['news_message'] ?? '',
            'created_at'      => date('Y-m-d H:i:s'),
            'attachements'    => json_encode([[
                                                  'type'           => UserNews::ATTACHMENT_TYPE_GIFT_ASSET,
                                                  'status'         => UserNews::STATUS_NEW,
                                                  'attachement_id' => 0,
                                                  'data'           => [
                                                      'a' => $requestData['cup_data']['asset_id'],
                                                      'p' => null,
                                                      'q' => 1,
                                                  ],
                                              ]
            ]),
        ]);

        CmsUser::whereId($user_id)->increment('gift_count');
        TrophyHistory::create([
            'news_id'     => $news->id,
            'sender_id'   => $requestData['cup_data']['sender_uid'],
            'receiver_id' => $requestData['cup_data']['receiver_uid'],
            'asset_id'    => $requestData['cup_data']['asset_id'],
            'cms_user'    => $user_id,
            'created_at'  => Carbon::now(),
        ]);

        return ['message' => __('Asset(s) successfully sent to user')];
    }

    /**
     * Validate form data
     *
     * @param $user_id
     * @param $data
     * @return array
     */
    private function trophyValidate($user_id, $data)
    {
        $message_list = [];

        $receiver = User::with('userPets')->where(['id' => $data['receiver_uid']])->first();
        if (empty($data['receiver_uid']) || $receiver['id'] != $data['receiver_uid']) {
            $message_list['receiver_uid'] = ["Winner Pet not found"];
        }

        $sender = User::with('userPets')->where(['id' => $data['sender_uid']])->first();
        if (empty($data['sender_uid']) || $sender['id'] != $data['sender_uid']) {
            $message_list['sender_uid'] = ["Pet not found"];
        }

        if ($sender['id'] == $receiver['id']) {
            $message_list['compare_id'] = ["Sender can not be the recipient"];
        }

        $asset_quote = TrophyCupConfig::with('assetId')->where(['user_id' => $user_id])->first();
        $maxAssetsCount = (int)$asset_quote->limit;

        $auth = CmsUser::where(['id' => auth()->id()])->first();
        if ((int)$auth['gift_count'] >= $maxAssetsCount) {
            $message_list['limit'] = ["Limit reached"];
        }

        return $message_list;
    }

}
