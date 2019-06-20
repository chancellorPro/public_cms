@extends('layouts.pages.config', [
    'title'  => 'Gift Wraps',
    'data'   => $data,
    'filter' => $filter,
])

@section('controls')
    {{-- Save --}}
    @include('common.buttons.base', [
        'name' => 'Add',
        'class' => 'add-embed',
        'btn_class' => 'btn-success btn-sm',
        'fa_class' => 'fa-plus',
        'dataset' => [
            'target' => 'gift-wraps-container',
            'template' => 'gift-wraps-template',
            'rowid' => 0,
            'event' => 'GIFT_WRAP_ROW_ADDED',
        ]
    ])

    {{-- Save --}}
    @include('common.buttons.base', [
        'route' => 'gift-wrap.update',
        'name' => 'Save',
        'class' => 'fast-save-page-custom',
        'btn_class' => 'btn-primary btn-sm',
        'fa_class' => 'fa-save',
    ])
@endsection

@section('content')

    <div class="table-responsive">
        <template id="gift-wraps-template">
            @include('asset.gift-wrap.row', [
                'asset_id' => 0,
            ])
        </template>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="id">@lang('Id')</th>
                    <th>@lang('Preview')</th>
                    <th>@lang('From')</th>
                    <th>@lang('To')</th>
                    <th class="xs">@lang('Enabled')</th>
                    <th class="actions">@lang('Actions')</th>
                </tr>
                <tr>
                    <th>@include('layouts.filter-col', ['filterType' => 'int', 'field' => 'id'])</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="filter-actions">@include('layouts.filter-col', ['filterType' => 'actions'])</th>
                </tr>
            </thead>
            <tbody id="gift-wraps-container" class="fast-save-page-container sortable">
                @foreach($data as $item)
                    @include('asset.gift-wrap.row', [
                        'asset_id' => $item->asset_id,
                    ])
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset("js/filter-col.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            init_filter_col("{{ route('gift-wrap.index') }}");
        })
    </script>
@endpush
