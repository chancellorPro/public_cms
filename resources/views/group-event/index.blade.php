@section('pageTitle', 'Group Events')
@extends('layouts.pages.config', [
    'title' => 'Group Events',
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

    <div class="row"><br>
        <div class="col-md-1 col-sm-1 col-xs-1">
            <input class="add-counter form-control" type="number" value="1" name="add_counter" width="50">
        </div>
        <a href="#" class="add-new-row btn btn-success btn-sm" title="@lang('common.add')">
            <i class="fa fa-plus" aria-hidden="true"></i> @lang('common.add') Row
        </a>

        {{-- Save --}}
        @include('common.buttons.base', [
            'route' => 'group-event.update',
            'name' => 'Save Events',
            'class' => 'save-page',
            'btn_class' => 'btn-primary btn-sm',
            'fa_class' => 'fa-save',
        ])
    </div>

    <div class="table-responsive">
        <template id="template">
            @include ('group-event.row-template', ['templatePlaceholder' => '%id%'])
        </template>

        <table class="table table-hover" id="group-event-users">
            <thead>
            <tr>
                <th>@lang('Name')</th>
                <th>@lang('Date from')</th>
                <th>@lang('Date to')</th>
                <th style="width: 400px;">@lang('Assets')</th>
                <th>@lang('Actions')</th>
            </tr>
            </thead>
            <tr>
                <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'name'])</th>
                <th><div class="form-group">
                        <input autocomplete="off" placeholder="Date from"
                               class="filter form-control datepicker"
                               value="{{ old("date_from") ?? '' }}" name="date_from" id="filter_date_from">
                    </div></th>
                <th>
                    <div class="form-group">
                        <input autocomplete="off" placeholder="Date to"
                               class="filter form-control datepicker"
                               value="{{ old("date_to") ?? '' }}" name="date_to" id="filter_date_to">
                    </div>
                </th>
                <th></th>
                <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
            </tr>
            <tbody class="group-event-save-container">
            @foreach($rows as $id => $row)
                @include ('group-event.row-template', [
                'item' => $row,
                'templatePlaceholder' => $row['id'],
                'assets' => $assets
                ])
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row"><br>
        <div class="col-md-1 col-sm-1 col-xs-1">
            <input class="add-counter form-control" type="number" value="1" name="add_counter" width="50">
        </div>
        <a href="#" class="add-new-row btn btn-success btn-sm" title="@lang('common.add')">
            <i class="fa fa-plus" aria-hidden="true"></i> @lang('common.add') Row
        </a>

        {{-- Save --}}
        @include('common.buttons.base', [
            'route' => 'group-event.update',
            'name' => 'Save Events',
            'class' => 'save-page',
            'btn_class' => 'btn-primary btn-sm',
            'fa_class' => 'fa-save',
        ])
    </div>
@endsection

@push('scripts')
    <script src="{{ asset("js/filter-col.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            init_filter_col("{{ route('group-event.index') }}");
        })
    </script>
@endpush
