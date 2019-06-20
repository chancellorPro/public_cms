<tr id="row<?=$templatePlaceholder?>"
    data-id="<?=$templatePlaceholder?>">
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input type="text"
                       class="form-control"
                       name="nla[{{$templatePlaceholder}}][name]"
                       value="{{ $item['name'] ?? '' }}">

                <input type="hidden"
                       name="nla[{{$templatePlaceholder}}][id]"
                       class="id"
                       value="{{ $templatePlaceholder}}">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input class="form-control"
                       name="nla[{{$templatePlaceholder}}][sort]"
                       value="{{ $item['sort'] ?? '' }}">
            </div>
        </div>
    </td>
    <td>
        @if(!empty($item['id']))
            {{-- Remove Item --}}
            @include('common.buttons.base', [
                'route' => 'group-event.destroy',
                'route_params' => [
                    'id' => $item['id'] ?? '',
                ],
                'btn_body' => __('Delete'),
                'btn_class' => 'btn-danger',
                'class' => 'ajax-confirm-action',
                'dataset' => [
                    'method' => 'DELETE',
                    'header' => __('Delete dye?'),
                    'btn-name' => __('Delete'),
                    'btn-class' => 'btn-danger',
                    'dismiss' => 1,
                    'reload' => 1,
                ],
            ])
        @else
            @include('common.buttons.base', [
                'name' => __('Delete'),
                'btn_class' => 'btn-danger btn-sm delete-row',
            ])
        @endif
    </td>
</tr>
