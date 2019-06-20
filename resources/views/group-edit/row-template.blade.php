<tr id="row<?=$templatePlaceholder?>"
    data-id="<?=$templatePlaceholder?>">
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input type="radio" data-id="{{$templatePlaceholder}}" name="is_main" {{ $item->is_main == 1 ? 'checked' : '' }}>
                <input type="hidden" class="form-control" id="id" name="ga[{{$templatePlaceholder}}][id]"
                       value="<?=$templatePlaceholder?>">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class="col-md-12">
                <input readonly type="text" class="form-control " name="ga[{{$templatePlaceholder}}][receiver_id]"
                       value="{{ $item->receiver_id ?? '' }}">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class="col-md-12">
                <input readonly type="text" class="form-control " name="ga[{{$templatePlaceholder}}][name]"
                       value="{{ !empty($item->user) ? $item->user->first_name . ' ' . $item->user->last_name ?? '' : '' }}">
            </div>
        </div>
    </td>
    <td>
        {{-- Remove Item --}}
        @include('common.buttons.base', [
            'route' => 'group.destroy',
            'route_params' => [
                'id' => $templatePlaceholder ?? '',
            ],
            'btn_body' => __('Delete'),
            'btn_class' => 'btn-danger',
            'class' => 'ajax-confirm-action',
            'dataset' => [
                'method' => 'DELETE',
                'header' => __('Delete user from group?'),
                'btn-name' => __('Delete'),
                'btn-class' => 'btn-danger',
                'dismiss' => 1,
                'reload' => 1,
            ],
        ])
    </td>
</tr>
