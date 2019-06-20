<div class="row">

    <h3>Import</h3>
    <div class="x_content">
        @if(count($nlaAssets))
            <div class="col-sm-6 x_panel"><h4>Last updated: {{ $nlaAssets->max('created_at') }}</h4></div>
        @endif
        <div class="col-sm-6 x_panel"><h4>New assets count: {{ count($assets) }}</h4>
            @if(count($assets))
                {{-- Import --}}
                <label>Import new assets from Pet City</label>
                @include('common.buttons.base', [
                    'route' => 'nla-asset.import',
                    'btn_body' => __('Import'),
                    'btn_class' => 'btn-primary',
                    'class' => 'ajax-submit-action',
                    'dataset' => [
                        'method' => 'POST',
                        'reload' => 1
                    ],
                ])
            @endif
        </div>
    </div>
</div>

<div class="row">
    <h3>Multi assign</h3>
    <div class="x_panel">
        @include('layouts.form-fields.select2', [
            'name' => "category",
            'collection' => $categories,
            'id' => 'id',
            'value' => 'name',
            'label' => __('Categories'),
            'selected' => 0,
        ])

        @include('layouts.form-fields.text', [
            'name'  => 'assets_ids',
            'label' => __('Assets IDs'),
        ])

        @include('common.buttons.base', [
            'btn_body' => __('Assign'),
            'btn_class' => 'btn-primary btn-sm',
            'class' => 'asset-assign',
        ])
    </div>
</div>
