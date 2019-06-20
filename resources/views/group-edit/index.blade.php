@section('pageTitle', 'All Group Admins')
@extends('layouts.pages.config', [
    'title' => 'All Group Admins',
])

@section('content')
    <ul class="nav nav-tabs deploy-tabs" id="deployTab" role="tablist">
        <li class="nav-item @if($activeDirection == 'dev') active @endif">
            <a class="nav-link" id="dev-tab" data-toggle="tab" href="#dev" role="tab" aria-controls="dev"
               aria-selected="true">Dev</a>
        </li>
        <li class="nav-item @if($activeDirection == 'stage') active @endif">
            <a class="nav-link" id="stage-tab" data-toggle="tab" href="#stage" role="tab" aria-controls="stage"
               aria-selected="false">Stage</a>
        </li>
        <li class="nav-item @if($activeDirection == 'live') active @endif">
            <a class="nav-link" id="live-tab" data-toggle="tab" href="#live" role="tab" aria-controls="live"
               aria-selected="false">Live</a>
        </li>
    </ul>

    <div style="width: 600px; margin: 40px auto;">
        <div style="width: 100%; margin-bottom: 20px;">
            <table border="0">
                <tr>
                    <th colspan="2"><h2>User search</h2></th>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        UID <input type="text" name="sender" id="sender" placeholder="123456" value="">
                        <b>OR</b> Player Name
                        <input type="text" placeholder="Player`s FB Name" name="sender_name" id="sender_name" value="">
                        <input type="button" id="find_sender" value="Find pet" data-route="{{ route('group.find') }}">

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
                        <input type="hidden" name="user_id" id="sender_uid" value="">
                    </td>
                </tr>
            </table>
            <input id="store" type="submit" value="Add to admin group" data-route="{{ route('group.store') }}">
        </div>
    </div>

    <div class="table-responsive">
        <div class="">
            @include('common.buttons.base', [
                'route' => 'group.update',
                'name' => __('Save'),
                'fa_class' => '',
                'btn_class' => 'btn-primary btn-sm',
                'class' => 'update-row',
            ])
        </div>
        <template id="user_template">
            @include ('group-edit.find-template', ['templatePlaceholder' => '%id%'])
        </template>

        <table class="table table-hover" id="group-users">
            <thead>
            <tr>
                <th class="id">@lang('Is main')</th>
                <th>@lang('User ID')</th>
                <th>@lang('Name')</th>
                <th class="actions">@lang('Actions')</th>
            </tr>
            <tr>
                <th></th>
                <th>@include('layouts.filter-col', ['filterType' => 'int', 'field' => 'receiver_id'])</th>
                <th></th>
                <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
            </tr>
            </thead>
            <tbody class="group-save-container">
            @foreach($rows as $id => $row)
                @include ('group-edit.row-template', ['item' => $row, 'templatePlaceholder' => $row->id])
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset("js/filter-col.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            init_filter_col("{{ route('group.edit') }}");
        })
    </script>
@endpush
