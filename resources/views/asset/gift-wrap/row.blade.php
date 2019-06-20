<tr id="gift-wrap-{{ $item->asset_id ?? '%embedBlockId%' }}">
    <td>
        <input type="hidden"
               class="position"
               name="asset[{{$asset_id}}][gift_wrap][position]"
               value="{{$item->position or 0}}"
        />

        @include('layouts.form-fields.input', [
            'name' => "asset[{$asset_id}][gift_wrap][asset_id]",
            'label' => false,
            'value' => $item->asset_id ?? '',
            'class' => 'asset-id',
            'attrs' => !empty($item->asset_id) ? ['readonly' => true] : [],
        ])
    </td>
    <td>
        @if (!empty($item->asset->preview_url))
            @include('common.image.preview', [
                'url' => $item->asset->preview_url
            ])
        @endif
    </td>
    <td>
        @include('layouts.form-fields.input', [
            'name' => "asset[{$asset_id}][gift_wrap][started_at]",
            'label' => false,
            'value' => !empty($item->started_at) ? $item->started_at->format('Y-m-d') : '',
            'class' => 'datepicker',
        ])
    </td>
    <td>
        @include('layouts.form-fields.input', [
            'name' => "asset[{$asset_id}][gift_wrap][finished_at]",
            'label' => false,
            'value' => !empty($item->finished_at) ? $item->finished_at->format('Y-m-d') : '',
            'class' => 'datepicker',
        ])
    </td>
    <td>
        <input type="checkbox"
               {{ !empty($item->enabled) || empty($item->asset_id) ? 'checked' : '' }}
               name="asset[{{$asset_id}}][gift_wrap][enabled]"
               value="1"
        />
    </td>
    <td>
        {{-- Edit asset --}}
        @if (!empty($item->asset_id))
        <a href="{{ route('assets.edit', ['id' => $item->asset_id, '_r' => url()->full()]) }}">
            <button class="btn btn-primary btn-sm">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                @lang('Edit')
            </button>
        </a>
        @endif

        {{-- ADP Source --}}
        @if(!empty($item->asset->cmsAdp))
            <a href="{{ route('cms-adps.edit', ['id'=>$item->asset->cmsAdp->id]) }}">
                <button class="btn btn-primary btn-sm">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    @lang('Adp source')
                </button>
            </a>
        @endif

        {{-- Delete --}}
        @include('common.buttons.delete', [
            'route' => 'gift-wrap.destroy',
            'route_params' => [
                'id' => $asset_id,
            ],
            'class' => 'ajax-confirm-action-custom',
        ])
    </td>
</tr>
