<?php

namespace App\Http\Controllers\Certs;

use App\Http\Controllers\Controller;
use App\Http\Requests\CmsUser\CertRequest;
use App\Models\Cms\CertHistory;
use App\Models\Cms\Certificate;
use App\Models\Cms\CertificateConfig;
use App\Models\Cms\CmsUser;
use App\Models\Cms\TrophyCupConfig;
use App\Models\Cms\TrophyHistory;
use App\Models\User\User;
use App\Models\User\UserNews;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class CertificateController
 */
class CertificateController extends Controller
{

    /**
     * Show the send cert form.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = CmsUser::with('cmsRoles')->whereId(auth()->id())->first();
        if (!in_array(CmsUser::ADMIN, array_column($user->cmsRoles->toArray(), 'id'))) {
            if(empty($request->get('environment'))) {
                session()->put('environment', 'live');
            }
        }

        $user_id = auth()->id();
        $auth = CmsUser::where(['id' => $user_id])->first();
        $asset_quote = CertificateConfig::with('assetId')->where(['user_id' => $user_id])->first();
        $assets_list = Certificate::with('assetId')->where(['status' => Certificate::IS_ACTIVE])->get();

        return view('certificate.index', [
            'assets_list' => $assets_list,
            'asset_quote' => $asset_quote,
            'cert_count'  => $auth['cert_count'],
            'env'         => environment()
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
    public function send(CertRequest $request)
    {
        $requestData = $request->get('cert_data');
        $user_id = auth()->id();
        $message_list = $this->certValidate($user_id, $requestData);

        if (!empty($message_list)) {
            return ['errors' => $message_list];
        }

        $news = UserNews::create([
            'user_id'         => $requestData['sender_uid'],
            'interlocutor_id' => $requestData['receiver_uid'],
            'direction'       => UserNews::DIRECTION_FROM_ME,
            'type'            => UserNews::NEWS_TYPE_GIFT_TYPE,
            'status'          => UserNews::STATUS_NEW,
            'message'         => $requestData['news_message'] ?? '',
            'created_at'      => date('Y-m-d H:i:s'),
            'attachements'    => json_encode([[
                                                  'type'           => UserNews::ATTACHMENT_TYPE_GIFT_ASSET,
                                                  'status'         => UserNews::STATUS_NEW,
                                                  'attachement_id' => 0,
                                                  'data'           => [
                                                      'a' => $requestData['asset_id'],
                                                      'p' => [
                                                          'name'  => $requestData['name'],
                                                          'event' => $requestData['event'],
                                                          'group' => $requestData['group'],
                                                          'date'  => $requestData['date'],
                                                      ],
                                                      'q' => 1,
                                                  ],
                                              ]
            ]),
        ]);

        CmsUser::whereId($user_id)->increment('cert_count');
        CertHistory::create([
            'news_id'     => $news->id,
            'sender_id'   => $requestData['sender_uid'],
            'receiver_id' => $requestData['receiver_uid'],
            'asset_id'    => $requestData['asset_id'],
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
    private function certValidate($user_id, $data)
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

        $asset_quote = CertificateConfig::with('assetId')->where(['user_id' => $user_id])->first();
        $maxAssetsCount = (int)$asset_quote->limit;
        $auth = CmsUser::where(['id' => auth()->id()])->first();

        if ((int)$auth['cert_count'] >= $maxAssetsCount) {
            $message_list['limit'] = ["Limit reached"];
        }

        return $message_list;
    }

}
