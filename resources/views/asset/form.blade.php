@php
   $assetModel = isset($asset) ? $asset : null;
@endphp

@include('common.form.history')

@include('layouts.form-fields.input', ['model' => $assetModel, 'name' => 'name'])

@include('layouts.form-fields.select2', [
    'model' => $assetModel,
    'name' => 'type',
    'collection' => $types,
    'id' => 'id',
    'value' => 'name',
    'fieldId' => 'asset-form-type',
    'attrs' => [
        'data-subtype' => $assetModel->subtype ?? '',
    ],
])

@include('layouts.form-fields.select2', [
    'model' => $assetModel,
    'name' => 'subtype',
    'collection' => [],
    'id'=>'id',
    'value'=>'name',
    'fieldId' => 'subtype',
])

<div id="asset-form-action-type" class="hide">
    @include('layouts.form-fields.select2', [
        'model' => $assetModel,
        'name' => 'action_type_id',
        'collection' => $actionTypes,
        'id'=>'id',
        'value'=>'name',
        'fieldId' => 'action_type_id',
        'addempty' => true,
    ])
</div>

<div id="asset-form-collection" class="hide">
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            @include('layouts.form-fields.input', [
                'model' => $assetModel,
                'name' => 'collection_number',
                'fieldId' => 'collection-number',
                'label' => __('Collection'),
            ])
        </div>
        <div class="col-sm-4">
            @include('common.buttons.create', [
                'route' => 'assets.collection',
                'name' => __('Get Last Collection ID'),
                'class' => '',
                'id' => 'get-last-collection-number',
            ])
        </div>
    </div>
</div>

@php
$defaultPrice = 0;
if (empty($assetModel->cash_price) && empty($assetModel->coins_price)) {
    if (empty($assetModel->type) || $assetModel->type != \App\Models\Cms\Asset::ASSET_TYPE_BODY_PART) {
        $defaultPrice = 9999;
    }
}
@endphp

<div class="prices">
    @include('layouts.form-fields.input', [
        'model' => $assetModel,
        'name' => 'cash_price'
    ])

    @include('layouts.form-fields.input', [
        'model' => $assetModel,
        'name' => 'coins_price',
        'value' => empty($assetModel->cash_price) && empty($assetModel->coins_price)
            ? $defaultPrice
            : $assetModel->coins_price,
    ])
</div>

@include('layouts.form-fields.file', [
    'file' => !empty($assetModel) ? $assetModel->preview_url : null,
    'type' => 'image',
    'name' => 'preview'
])

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or __('common.create') }}">
    </div>
</div>

@push('globals')
    <script type="text/javascript">
        var SUB_TYPES = @json($subtypeGroups);
    </script>
@endpush
