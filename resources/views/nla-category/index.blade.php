@section('pageTitle', 'Nla categories')
@extends('layouts.pages.config', [
    'title' => 'Nla categories',
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
            'name' => 'Save categories',
            'class' => 'save-page',
            'btn_class' => 'btn-primary btn-sm',
            'fa_class' => 'fa-save',
        ])
    </div>

    <div class="table-responsive">

        <template id="template">
            @include ('nla-category.row-template', ['templatePlaceholder' => '%id%'])
        </template>

        <table class="table table-hover" id="nla">
            <thead>
            <tr>
                <th>@lang('Name')</th>
                <th>@lang('Section')</th>
                <th>@lang('Sort')</th>
                <th class="actions">@lang('Actions')</th>
            </tr>
            <tr>
                <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'name'])</th>
                <th>@include('layouts.filter-col', ['filterType' => 'select', 'field' => 'section_id', 'filterCollection' => $sections])</th>
                <th>@include('layouts.filter-col', ['filterType' => 'int', 'field' => 'sort'])</th>
                <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
            </tr>
            </thead>
            <tbody class="container">
            @foreach($rows as $id => $row)
                <tr>
                    @include ('nla-category.row-template', ['templatePlaceholder' => $row->id, 'item' => $row])
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset("js/filter-col.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            init_filter_col("{{ route('nla-category.index') }}");
        })
    </script>
@endpush
