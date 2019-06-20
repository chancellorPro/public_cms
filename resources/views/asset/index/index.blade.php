@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('Assets')</h3>
                </div>

                <div class="title_right">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  
                    <div class="x_panel">
                        <div class="x_content">

                            <div class="pagination-wrapper"> {!! $assets->appends($filter)->render() !!} </div>

                            <div class="table-responsive">
                                <table id="assets-table" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="id">@lang('Id')</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Type')</th>
                                            <th>@lang('Sub Type')</th>
                                            <th>@lang('Price')</th>
                                            <th class="xs">@lang('Sell')<br>@lang('status')</th>
                                            <th>@lang('Which Shop')</th>
                                            <th>@lang('Attributes')</th>
                                            <th style="min-width: 150px">@lang('Furniture Behavior')</th>
                                            <th class="xs">@lang('Collection')</th>
                                            <th>@lang('Last updated')</th>
                                            <th class="actions">@lang('Actions')</th>
                                        </tr>

                                        <tr>
                                            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'id'])</th>
                                            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'name'])</th>
                                            <th>@include('layouts.filter-col', ['filterType' => 'select', 'field' => 'type', 'filterCollection' => $types])</th>
                                            <th>@include('layouts.filter-col', ['filterType' => 'select', 'field' => 'subtype', 'filterCollection' => $subTypes])</th>
                                            <th>
                                                @include('layouts.filter-col', ['filterType' => 'string', 'field' => 'cash_price', 'class' => 'icon cash'])
                                                @include('layouts.filter-col', ['filterType' => 'string', 'field' => 'coins_price', 'class' => 'icon coin'])
                                            </th>
                                            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'sell_status'])</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>
                                                @include('common.buttons.create', [
                                                    'route' => 'assets.collection',
                                                    'name' => __('Last ID'),
                                                    'class' => '',
                                                    'id' => 'get-last-collection-number',
                                                ])
                                                @include('layouts.form-fields.input', [
                                                    'name' => 'collection_number',
                                                    'fieldId' => 'collection-number',
                                                    'label' => false,
                                                    'type' => 'number',
                                                    'class' => 'filter',
                                                    'value' => request('collection_number'),
                                                ])
                                            </th>
                                            <th></th>
                                            <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
                                        </tr>

                                        
                                    </thead>
                                    <tbody>
                                    @foreach($assets as $item)
                                        <tr class="fast-save-container">
                                            <td>
                                                <div class="col-sm-9">
                                                {{ $item->id }}
                                                    @if($available_bundles_types != count($item->bundles))
                                                        <span class="form-control btn-danger" title="No bundle files uploaded">
                                                            <i class="fa fa-exclamation-triangle"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-horizontal">
                                                @include('layouts.form-fields.input', [ 'name' => "name", 'label' => false, 'value' => $item->name ])
                                                </div>
                                                <div class="list-thumbnail" data-toggle="popover" data-full="{{ Storage::url($item->preview_url) }}">
                                                    <img class="img-responsive" src="{{ Storage::url($item->preview_url) }}" title="{{$item->name}}">
                                                </div>
                                                
                                                
                                            </td>
                                            <td>
                                                <input type="hidden" name="type" value="{{ $item->type }}">
                                                {{ !empty(\App\Models\Cms\Asset::ASSET_TYPE_ALIASES[$item->type]) ? \App\Models\Cms\Asset::ASSET_TYPE_ALIASES[$item->type] : '' }}
                                            </td>
                                            <td>
                                                {{ $item->assetSubtype->name ?? '' }}
                                            </td>
                                            <td>
                                                @if ($item->type != \App\Models\Cms\Asset::ASSET_TYPE_BODY_PART)
                                                    <div class="form-horizontal">
                                                        @include('layouts.form-fields.input', [ 'name' => "cash_price", 'class' => 'icon cash', 'label' => false, 'value' => $item->cash_price ])
                                                        @include('layouts.form-fields.input', [ 'name' => "coins_price", 'class' => 'icon coin', 'label' => false, 'value' => $item->coins_price ])
                                                    </div>
                                                @endif
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                @include('asset.index.sub_type')
                                            </td>
                                            <td>
                                                @include('asset.index.action_type')
                                            </td>
                                            <td>
                                                @if ($item->type == \App\Models\Cms\Asset::ASSET_TYPE_CLOTHES)
                                                    @include('layouts.form-fields.input', [
                                                        'name' => "collection_number",
                                                        'label' => false,
                                                        'value' => $item->collection_number
                                                    ])
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->updatedBy->name }} <br>
                                                {{ $item->updated_at }}
                                            </td>
                                            <td>
                                                <a class="fast-save" href="{{ route('assets.inline_update', ['id'=>$item->id]) }}" title="Save Asset">
                                                    <button class="btn btn-success btn-sm">
                                                        <i class="fa fa-save" aria-hidden="true"></i>
                                                        @lang('Save')
                                                    </button>
                                                </a>
                                                <a href="{{ route('assets.edit', [
                                                        'id' => $item->id,
                                                        '_r' => url()->full(),
                                                    ]) }}">
                                                    <button class="btn btn-primary btn-sm">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        @lang('Edit')
                                                    </button>
                                                </a>

                                                @if(!empty($item->cmsAdp))
                                                    <a href="{{ route('cms-adps.edit', ['id'=>$item->cmsAdp->id]) }}">
                                                        <button class="btn btn-primary btn-sm">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            @lang('Adp source')
                                                        </button>
                                                    </a>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination-wrapper"> {!! $assets->appends($filter)->render() !!} </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset("js/filter-col.js") }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        init_filter_col("{{ route('assets.index') }}");
    })
</script>
@endpush
