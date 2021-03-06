@section('pageTitle', 'Trophy cup users')
@extends('layouts.pages.config', [
    'title' => 'Trophy cup users',
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

    <div class="table-responsive">

        <div class="row"><br>
            <div class="col-md-1 col-sm-1 col-xs-1">
            @include('common.buttons.base', [
                'route' => 'trophy-cup-users.update',
                'name' => __('Save'),
                'fa_class' => '',
                'btn_class' => 'btn-primary btn-sm',
                'class' => 'update-row',
            ])
            </div>
        </div>
        <template id="user_template">
            @include ('trophy-cup-users.row-template', ['templatePlaceholder' => '%id%'])
        </template>

        <table class="table table-hover" id="trophy-cup-users">
            <thead>
            <tr>
                <th class="id">@lang('User Id')</th>
                <th>@lang('Name')</th>
                <th>@lang('AssetId')</th>
                <th>@lang('Limit')</th>
                <th class="actions">@lang('Actions')</th>
            </tr>
            <tr>
                <th>@include('layouts.filter-col', ['filterType' => 'int', 'field' => 'id'])</th>
                <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'name'])</th>
                <th>@include('layouts.filter-col', ['filterType' => 'int', 'field' => 'asset_id'])</th>
                <th>@include('layouts.filter-col', ['filterType' => 'int', 'field' => 'limit'])</th>
                <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
            </tr>
            </thead>
            <tbody class="trophy-save-container">
            @foreach($rows as $id => $row)
                @include ('trophy-cup-users.row-template', ['item' => $row, 'templatePlaceholder' => $row->id])
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset("js/filter-col.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            init_filter_col("{{ route('trophy-cup-users.index') }}");
        })
    </script>
@endpush
