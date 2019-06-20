<div class="row"><br>
    <div class="col-md-2 col-sm-2 col-xs-2">
        @include('layouts.form-fields.select2', [
            'name' => "category",
            'collection' => $categories,
            'id' => 'id',
            'value' => 'name',
            'label' => false,
            'selected' => 0,
        ])
    </div>
    <div class="col-md-2 col-sm-2 col-xs-2">
        {{-- Save --}}
        @include('common.buttons.base', [
            'name' => 'Assign to category',
            'btn_class' => 'btn-primary btn-sm',
            'fa_class' => 'fa-save',
            'class' => 'update-assign',
            'dataset' => [
                'route' => 'nla-update',
            ]
        ])
    </div>


    <div class="col-sm-5">
        <div class="pagination-wrapper public-pagination"> {!! $nlaAssets->appends($filter)->render() !!} </div>
    </div>

    <div class="col-sm-2 pull-right">
        <select id="qty" name="qty" class="form-control pull-right">
            <option {{ $record_per_page == 10 ? 'selected' : '' }} value="10">10</option>
            <option {{ $record_per_page == 100 ? 'selected' : '' }} value="100">100</option>
            <option {{ $record_per_page == 999999 ? 'selected' : '' }} value="999999">All</option>
        </select>
    </div>
    <div class="col-sm-2 pull-right" style="width: 120px;">
        <label for="qty" class="pull-left">Items per page:</label>
    </div>
</div>

<div class="table-responsive">

    <template id="template">
        @include ('nla-asset.row-template', ['templatePlaceholder' => '%id%'])
    </template>

    <table class="table table-hover" id="nla">
        <thead>
        <tr>
            <th class="id">@lang('ID')</th>
            <th>@lang('Name')</th>
            <th>@lang('Preview')</th>
            <th>@lang('Currency')</th>
            <th>@lang('Categories')</th>
            <th>@lang('Sell start')</th>
            <th>@lang('Sell end')</th>
            <th>@lang('Sell shop')</th>
            <th class="actions">@lang('Actions')</th>
        </tr>
        <tr>
            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'id'])</th>
            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'name'])</th>
            <th></th>
            <th></th>
            <th>@include('layouts.filter-col', ['filterType' => 'select', 'field' => 'category', 'filterCollection' => $categories])</th>
            <th></th>
            <th></th>
            <th></th>
            <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
        </tr>
        </thead>
        <tbody class="container">
        @foreach($nlaAssets as $id => $asset)
            <tr>
                @include ('nla-asset.row-template', ['templatePlaceholder' => $asset->id, 'item' => $asset])
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
