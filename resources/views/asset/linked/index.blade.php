@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('Linked Assets')</h3>
                </div>

                <div class="title_right">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  
                    <div class="x_panel">
                        <div class="x_content">

                            <div class="pagination-wrapper"> {!! $linkedAssets->appends($filter)->render() !!} </div>

                            <div class="table-responsive">
                                <table id="assets-table" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th colspan="3">PC1</th>
                                        <th colspan="3">PC2</th>
                                        <th rowspan="2" class="actions">@lang('Actions')</th>
                                    </tr>
                                        <tr>
                                            <th class="id">@lang('Id')</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Preview')</th>

                                            <th>@lang('Id')</th>
                                            <th>@lang('Name')</th>
                                            <th>@lang('Preview')</th>


                                        </tr>

                                        <tr>
                                            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'pc1_asset_id'])</th>
                                            <th></th>

                                            <th></th>
                                            <th>@include('layouts.filter-col', ['filterType' => 'string', 'field' => 'asset_id'])</th>
                                            <th></th>

                                            <th></th>
                                            <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
                                        </tr>

                                        
                                    </thead>
                                    <tbody>
                                    @foreach($linkedAssets as $item)
                                        <tr class="fast-save-container">
                                            <td>
                                                {{ $item->pc1_asset_id }}
                                                <input type="hidden" value="{{ $item->pc1_asset_id }}" name="pc1_asset_id">
                                            </td>
                                            <td>
                                                @if(!empty($pc1AssetsData[$item->pc1_asset_id]))
                                                    {{ $pc1AssetsData[$item->pc1_asset_id]['name'] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($pc1AssetsData[$item->pc1_asset_id]))
                                                    <div class="list-thumbnail" data-toggle="popover" data-full="{{ $pc1AssetsData[$item->pc1_asset_id]['preview'] }}">
                                                        <img class="img-responsive" src="{{ $pc1AssetsData[$item->pc1_asset_id]['preview'] }}">
                                                    </div>
                                                @endif
                                            </td>

                                            <td>
                                                @include('layouts.form-fields.input', [ 'name' => "asset_id", 'label' => false, 'value' => $item->asset_id, 'class' => 'asset' ])
                                            </td>

                                            <td class="asset-name">
                                                @if($item->asset)
                                                    {{ $item->asset->name }}
                                                @endif
                                            </td>

                                            <td class="asset-preview">
                                                @php
                                                    $previewUrl = $item->asset ? Storage::url($item->asset->preview_url) : '';
                                                    $title = $item->asset ? $item->asset->name : '';
                                                @endphp

                                                <div class="list-thumbnail" data-toggle="popover" data-full="{{ $previewUrl }}">
                                                    <img class="img-responsive" src="{{ $previewUrl }}" title="{{$title}}">
                                                </div>
                                            </td>


                                            <td>
                                                <a class="fast-save" href="{{ route('linked-assets.update', ['id'=>$item->id]) }}" title="Save">
                                                    <button class="btn btn-success btn-sm">
                                                        <i class="fa fa-save" aria-hidden="true"></i>
                                                        @lang('Save')
                                                    </button>
                                                </a><br><br>
                                                @if($item->asset)
                                                    <a href="{{ route('assets.edit', [
                                                            'id' => $item->asset->id,
                                                            '_r' => url()->full(),
                                                        ]) }}">
                                                        <button class="btn btn-primary btn-sm">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            @lang('Asset')
                                                        </button>
                                                    </a>
                                                @endif
                                                @if($item->asset && !empty($item->asset->cmsAdp))
                                                    <a href="{{ route('cms-adps.edit', ['id'=>$item->asset->cmsAdp->id]) }}">
                                                        <button class="btn btn-primary btn-sm">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            @lang('Adp source')
                                                        </button>
                                                    </a>
                                                @endif

                                                @include('common.buttons.delete', [
                                                    'route' => 'linked-assets.destroy',
                                                    'route_params' => [
                                                        'id' => $item->id,
                                                    ],
                                                    'dataset' => [
                                                        'header' => __('Delete link for') . ' ' . $item->pc1_asset_id,
                                                    ],
                                                    'btn_class' => 'btn-danger btn-sm',
                                                ])
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination-wrapper"> {!! $linkedAssets->appends($filter)->render() !!} </div>
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
        init_filter_col("{{ route('linked-assets.index') }}");
    })

    /**
     * Global SWOW_ASSET_ROUTE for showAsset.js
     */
    const SWOW_ASSET_ROUTE = '{{ route('asset.info') }}';
</script>

@endpush
