@section('pageTitle', 'Send Special Prize')
@extends('layouts.pages.config', [
    'title' => 'Send Special Prize',
])

@section('content')
    <div style="width: 650px; margin: 0 auto;">
        <div style="width: 100%; margin-bottom: 20px;">
            <template id="user_template">
                @include ('trophies.row-template')
            </template>
            <table id="send-container" border="0" style="width: 100%">
                <tr>
                    <th colspan="2">Sender</th>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        Enter Pet ID <input type="text"
                                            name="sender"
                                            id="sender"
                                            placeholder="123456"
                                            value="{{ old('sender') ?? '' }}">
                        or Player Name
                        <input type="text" placeholder="Player`s FB Name" name="sender_name" id="sender_name"
                               value="{{ old('sender_name') ?? '' }}">
                        <input type="button" id="find_sender" value="Find user"
                               data-route="{{ route('trophies.find') }}"
                               data-prefix="sender">
                        {{--<img src="images/info_16.png" alt="info"--}}
                        {{--title="UID can be found under Application Settings (in Sprockets Menu)"/>--}}
                        <br/>

                        <table class="table" style="display: none;">
                            <thead>
                            <tr style="width: 100%">
                                <th></th>
                                <th>Avatar</th>
                                <th>User Name</th>
                                <th>User Id</th>
                                <th>Pet Name</th>
                                <th>Level</th>
                            </tr>
                            </thead>
                            <tbody id="sender_list"></tbody>
                        </table>

                        <input type="hidden" name="loot_data[sender_uid]" id="sender_uid"
                               value="{{ old('sender_uid') ?? '' }}">
                        <input type="hidden" name="loot_data[user_id]" value="{{ auth()->id() }}">
                        <input type="hidden" name="loot_data[event_id]" value="{{ $event['id'] }}">
                    </td>
                </tr>

                <tr>
                    <th colspan="2">Receiver</th>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        Enter Pet ID <input type="text" name="receiver" id="receiver" placeholder="654321"
                                            value="{{ old('receiver') ?? '' }}">
                        or Player Name
                        <input type="text" placeholder="Player`s FB Name" name="receiver_name" id="receiver_name"
                               value="{{ old('receiver_name') ?? '' }}">
                        <input type="button" id="find_receiver" value="Find user"
                               data-route="{{ route('trophies.find') }}"
                               data-prefix="receiver">
                        {{--<img src="images/info_16.png" alt="info"--}}
                        {{--title="UID can be found under Application Settings (in Sprockets Menu)"/>--}}
                        <br/>

                        <table class="table" style="display: none;">
                            <thead>
                            <tr style="width: 100%">
                                <th></th>
                                <th>User Name</th>
                                <th>User Id</th>
                                <th>Pet Name</th>
                                <th>Level</th>
                            </tr>
                            </thead>
                            <tbody id="receiver_list"></tbody>
                        </table>

                        <input type="hidden" name="loot_data[receiver_uid]" id="receiver_uid"
                               value="{{ old('receiver_uid') ?? '' }}"><br>
                    </td>
                </tr>

                <tr>
                    <th colspan="2">Special Prize Being Sent</th>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="assets_list">
                            <table>
                                @foreach ($event['embed_box'] as $item)
                                    <tr>
                                        <td>
                                            <div class="assets_block">
                                                <img data-prize="{{ $item['asset_id'] }}"
                                                     src="{{ Storage::url($assets[$item['asset_id']]['preview_url'])
                                             }}" style="height: 35px;">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <input type="hidden" id="asset_id" name="loot_data[asset_id]"
                                   value="{{ old('loot_data[asset_id]') ?? '' }}">
                        </div>
                    </td>
                </tr>

                <tr>
                    <th style="width: 200px">Add a Note to receiver player <br>
                        <small>Characters left: <span id="message_length">145</span></small>
                    </th>
                    <td style="">
                        <textarea style="resize: none" name="loot_data[news_message]" data-val="news_message"
                                  class="form-control limited" data-maxlength="145" maxlength="145"
                                  rows="10">{{ old('loot_data[news_message]') ?? '' }}</textarea><br>
                    </td>
                </tr>

                <tr>
                    <th colspan="2">
                        <input id="send" type="submit" value="Send to receiver"
                               data-route="{{ route('special-prizes.send') }}">
                        <input type="button" value="Cancel">
                        <input type="button" value="Return to Special Prizes">
                    </th>
                </tr>
            </table>
        </div>
    </div>
@endsection
