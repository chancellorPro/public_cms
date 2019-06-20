@section('pageTitle', 'Send certificate')
@extends('layouts.app')

@section('main_container')
    <style>
        th[colspan="2"] {
            text-align: center;
            background: #e7e7e7;
        }
    </style>

    <div class="right_col">

        <div class="page-title">
            <div class="title_left">
                <h3>@lang('Send certificate')</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div style="width: 600px; margin: 20px auto;">
            <template id="user_template">
                @include ('certificate.row-template')
            </template>
            <table border="0" id="cert-save-container">
                <tr>
                    <td colspan="2" align="center"><span id="cert_cups_count">{{ $cert_count }}</span>/
                        {{ $asset_quote['limit'] }} Gifts Sent
                        <br/>(You can create {{ $asset_quote['limit'] }} certificates per month)
                    </td>
                </tr>
                <?php if ($cert_count < $asset_quote['limit']) { ?>
                <tr>
                    <th colspan="2">Name of Cert Sender (Will not appear on cert).</th>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        Pet ID <input type="text" name="sender" id="sender" placeholder="123456"
                                      value="{{ old('sender') ?? '' }}">
                        <b>OR</b>
                        Player Name
                        <input type="text" placeholder="Player`s FB Name" name="sender_name"
                               id="sender_name" value="{{ old('sender_name') ?? '' }}">

                        <input type="button" id="find_sender" value="Find pet" data-prefix="sender"
                               data-route="{{ route('cert.find') }}">

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
                        <input type="hidden" name="cert_data[sender_uid]" id="sender_uid"
                               value="{{ old('cert_data[sender_uid]') ?? '' }}">
                    </td>
                </tr>

                <tr>
                    <th colspan="2">Winning Player Name (Will not appear on cert).</th>
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
                               data-route="{{ route('cert.find') }}">

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
                        <input type="hidden" name="cert_data[receiver_uid]" id="receiver_uid"
                               value="{{ old('cert_data[receiver_uid]') ?? '' }}">
                    </td>
                </tr>

                <tr>
                    <th colspan="2">Select Certificate to Grant</th>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="assets_list">
                            @foreach ($assets_list as $asset)
                                <img src="{{ Storage::url($asset->assetId->preview_url) }}"
                                     data-cert="{{ $asset->assetId->id }}"
                                     style="height: 45px;">
                            @endforeach
                            <input type="hidden" id="asset_id" name="cert_data[asset_id]"
                                   value="{{ old('cert_data[asset_id]') ?? '' }}">
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>Add a note to winner player<br>(Note will not appear on cert)<br>
                        <small>Characters left: <span id="news_message_length">145</span></small>
                    </th>
                    <td style="vertical-align: top;">
                            <textarea name="cert_data[news_message]" class="form-control limited validate"
                                      data-maxlength="145"
                                      maxlength="145">{{ old('cert_data[news_message]') ?? '' }}</textarea>
                    </td>
                </tr>
                <tr>
                    <th colspan="2">Enter text to show on Certificate:</th>
                </tr>
                <tr>
                    <th>
                        Player or Pet Name:<br>
                        <small><i>(Will appear on cert)</i></small>
                        <br>
                        <small>Characters left: <span id="name_length">25</span></small>
                    </th>
                    <td style="vertical-align: top;">
                        @include('layouts.form-fields.input', [
                            'name' => "cert_data[name]",
                            'attrs' => ['data-maxlength' => 25],
                            'label' => false,
                            'value' => old("cert_data[name]") ?? '',
                        ])
                    </td>
                </tr>
                <tr>
                    <th>
                        Name of Event that player won:<br>
                        <small><i>(Will appear on cert)</i></small>
                        <br>
                        <small>Characters left: <span id="event_length">25</span></small>
                    </th>
                    <td style="vertical-align: top;">
                        @include('layouts.form-fields.input', [
                            'name' => "cert_data[event]",
                            'attrs' => ['data-maxlength' => 25],
                            'label' => false,
                            'value' => old("cert_data[event]") ?? '',
                        ])
                    </td>
                </tr>
                <tr>
                    <th>
                        Your Group Name<br>
                        <small><i>(Will appear on cert)</i></small>
                        <br>
                        <small>Characters left: <span id="group_length">25</span></small>
                    </th>
                    <td style="vertical-align: top;">
                        @include('layouts.form-fields.input', [
                            'name' => "cert_data[group]",
                            'attrs' => ['data-maxlength' => 25],
                            'label' => false,
                            'value' => old('cert_data[group]') ?? '',
                        ])
                    </td>
                </tr>
                <tr>
                    <th>
                        Date of Event:<br>
                        <small><i>(Will appear on cert)</i></small>
                        <br>
                    </th>
                    <td style="vertical-align: top;">
                        @include('layouts.form-fields.input', [
                            'name' => "cert_data[date]",
                            'label' => false,
                            'value' => old("cert_data[date]") ?? '',
                            'class' => 'datepicker',
                        ])
                    </td>
                </tr>
                <tr>
                    <th colspan="2">
                        <input id="send" type="submit" value="Send to winning player"
                               data-route="{{ route('cert.send') }}">
                        <input id="cancel" type="button" value="Cancel">
                    </th>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
@endsection
