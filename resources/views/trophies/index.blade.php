@section('pageTitle', 'Group Trophies')
@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('Group Trophies')</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <template id="user_template">
                @include ('trophies.row-template')
            </template>
            <div class="row">

                <div style="width: 600px; margin: 0 auto;">
                    <div style="width: 100%; margin-bottom: 20px;">
                        @if(!empty($asset_quote['asset_id']))
                        <br>
                        <table border="0" id="trophy-save-container">
                            <tr>
                                <td colspan="2" align="center"><span id="trophy_cups_count">{{ $trophy_cups_count }}</span> /
                                    {{ $asset_quote['limit'] }} Trophies Sent<br/>(You can send {{ $asset_quote['limit'] }} trophies per
                                    month)
                                </td>
                            </tr>
                            @if ($trophy_cups_count < $asset_quote['limit'])
                            <tr>
                                <th colspan="2">Name of Trophy Sender (will not appear on trophy).</th>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    Pet ID <input type="text" name="sender" id="sender" placeholder="123456"
                                                  value="{{ old('cup_data[sender]') ?? '' }}">
                                    <b>OR</b>
                                    Player Name
                                    <input type="text" placeholder="Player`s FB Name" name="sender_name"
                                           id="sender_name" value="{{ old('cup_data[sender_name]') ?? '' }}">

                                    <input type="button" id="find_sender" value="Find pet" data-prefix="sender"
                                           data-route="{{ route('trophies.find') }}">

                                    <br/><br/>
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

                                    <br/>
                                    <input type="hidden" name="cup_data[sender_uid]" id="sender_uid"
                                           value="{{ old('cup_data[sender_uid]') ?? '' }}">
                                    <input type="hidden" name="cup_data[user_id]" value="{{ old('cup_data[user_id]') ?? '' }}">
                                </td>
                            </tr>

                            <tr>
                                <th colspan="2">Name of Winning Player (will not appear on trophy).</th>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    Pet ID <input type="text" name="receiver" id="receiver" placeholder="654321"
                                                  value="{{ old('receiver') ?? '' }}">
                                    <b>OR</b>
                                    Player Name
                                    <input type="text" placeholder="Player`s FB Name" name="receiver_name"
                                           id="receiver_name" value="{{ old('receiver_name') ?? '' }}">

                                    <input type="button" id="find_receiver" value="Find pet" data-prefix="receiver"
                                           data-route="{{ route('trophies.find') }}">

                                    <br/><br/>

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
                                    <br/>
                                    <input type="hidden" name="cup_data[receiver_uid]" id="receiver_uid"
                                           value="{{ old('cup_data[receiver_uid]') ?? '' }}">
                                </td>
                            </tr>

                            <tr>
                                <th colspan="2">Trophy To Award</th>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;">
                                    {{ $asset_quote->assetId->name }}
                                    @if(!empty($asset_quote->assetId->preview_url))
                                        <div class="list-thumbnail" data-toggle="popover"
                                             data-full="{{ Storage::url($asset_quote->assetId->preview_url) }}">
                                            <img class="img-responsive"
                                                 src="{{ Storage::url($asset_quote->assetId->preview_url) }}"
                                                 title="{{$asset_quote->assetId->name}}">
                                        </div>
                                    @endif

                                    <input type="hidden" id="asset_id" name="cup_data[asset_id]"
                                           value="{{ $asset_quote->assetId->id ?? 0 }}"
                                           style="width:50px;">
                                </td>
                            </tr>

                            <tr>
                                <th>Add a note to winner player<br>
                                    <small>Characters left: <span id="news_message_length">145</span></small>
                                </th>
                                <td style="vertical-align: top;">
                                        <textarea style="width: 400px;height: 100px;resize: none"
                                                  name="cup_data[news_message]"
                                                  rows="4" cols="50"
                                                  data-val="news_message" class="limited" data-maxlength="145"
                                                  maxlength="145">{{ old('cup_data[news_message]') ?? '' }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2"><br><br>
                                    <input id="send" type="submit" value="Send to winning player"
                                           data-route="{{ route('trophies.send') }}">
                                    <input id="cancel" type="button" value="Cancel">
                                </th>
                            </tr>
                            @endif
                        </table>
                        @else
                        Trophy Cup unavailable
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
