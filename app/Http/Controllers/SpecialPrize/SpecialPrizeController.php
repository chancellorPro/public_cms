<?php

namespace App\Http\Controllers\SpecialPrize;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupAdmin\GroupRequest;
use App\Models\Cms\Asset;
use App\Models\Cms\CmsUser;
use App\Models\Cms\EventLog;
use App\Models\Cms\GroupEvent;
use App\Models\User\User;
use App\Models\User\UserNews;
use App\Traits\FilterBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class SpecialPrizeController
 */
class SpecialPrizeController extends Controller
{

    use FilterBuilder;

    const FILTER_FIELDS = [
        'receiver_id' => 'equal',
    ];

    /**
     * Show group admin list.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $activeDirection = $request->get('direction', environment());
        $rows = GroupEvent::all()->filter(function($item) {
            if (Carbon::now()->between(
                Carbon::createFromFormat('Y-m-d H:i:s', $item->date_from),
                Carbon::createFromFormat('Y-m-d H:i:s', $item->date_to))
            ) {
                return $item;
            }
        })->keyby('id')->toArray();

        $event_log = EventLog::whereIn('event_id', array_column($rows, 'id'))->where(['cms_user_id' => auth()->user()->id])->get()->toArray();
        $asset_ids = [];
        foreach ($rows as $k => $item) {
            $assets_setup = json_decode($item['assets_setup'], true);
            foreach ($event_log as $event) {
                if ($event['event_id'] == $item['id']) {
                    foreach ($assets_setup as $n => $asset) {
                        if ($event['asset_id'] == $asset['asset_id'] && $asset['limit'] > 0) {
                            $assets_setup[$n]['limit']--;
                            $item['assets_setup'] = json_encode($assets_setup);
                        }
                    }
                }
            }

            $rows[$k]['embed_box'] = [];
            foreach ($assets_setup as $i => $v) {
                if ($v['limit'] > 0) {
                    $asset_ids[] = $v['asset_id'];
                    $rows[$k]['embed_box'][$i] = $v;
                }
            }
        }

        $assets = Asset::whereIn('id', $asset_ids)->get()->keyBy('id')->toArray();

        return view('special-prize.index', compact(['rows', 'activeDirection', 'assets']));
    }

    /**
     * Show group admin list.
     *
     * @param $id
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function form($id, Request $request)
    {
        $user = CmsUser::with('cmsRoles')->whereId(auth()->id())->first();
        if (!in_array(CmsUser::ADMIN, array_column($user->cmsRoles->toArray(), 'id'))) {
            if (empty($request->get('environment'))) {
                session()->put('environment', 'live');
            }
        }
        $event = GroupEvent::whereId($id)->first()->toArray();

        $asset_ids = [];
        $assets_setup = json_decode($event['assets_setup'], true);

        $event_log = EventLog::where(['event_id' => $id, 'cms_user_id' => auth()->user()->id])->get()->toArray();
        foreach ($event_log as $event) {
            foreach ($assets_setup as $n => $asset) {
                if ($event['asset_id'] == $asset['asset_id'] && $asset['limit'] > 0) {
                    $assets_setup[$n]['limit']--;
                }
            }
        }

        $event['embed_box'] = [];
        foreach ($assets_setup as $i => $v) {
            if ($v['limit'] > 0) {
                $asset_ids[] = $v['asset_id'];
                $event['embed_box'][$i] = $v;
            }
        }

        $assets = Asset::whereIn('id', $asset_ids)->get()->keyBy('id')->toArray();

        return view('special-prize.form', compact(['event', 'activeDirection', 'assets']));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function send(Request $request)
    {
        $requestData = $request->get('loot_data');
        $user_id = auth()->id();
        $message_list = $this->prizeValidate($user_id, $requestData);

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
                                                      'p' => [],
                                                      'q' => 1,
                                                  ],
                                              ]
            ]),
        ]);

        EventLog::create([
            'news_id'      => $news->id,
            'event_id'     => $requestData['event_id'],
            'asset_id'     => $requestData['asset_id'],
            'sender_id'    => $requestData['sender_uid'],
            'receiver_id'  => $requestData['receiver_uid'],
            'cms_user_id'  => $user_id,
            'created_at'   => Carbon::now(),
            'news_message' => $requestData['news_message'],
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
    private function prizeValidate($user_id, $data)
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

        $sended_count = EventLog::where(['cms_user_id' => $user_id])
            ->where(['event_id' => $data['event_id']])
            ->where(['asset_id' => $data['asset_id']])
            ->count();

        $event = GroupEvent::whereId($data['event_id'])->first();

        $limit = 0;

        foreach (json_decode($event['assets_setup'], true) as $item) {
            if ($item['asset_id'] == $data['asset_id']) {
                $limit = (int)$item['limit'];
            }
        }

        if ($limit == 0 || $sended_count >= $limit) {
            $message_list['limit'] = ["Limit reached"];
        }

        return $message_list;
    }
}
