<tr id="row<?=$templatePlaceholder?>"
    data-id="<?=$templatePlaceholder?>">
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input disabled type="radio" data-id="{{$templatePlaceholder}}" name="is_main"
                        {{ isset($item->cmsUser->name) ? $item->is_main == 1 ? 'checked' : '' : '' }}>
                <input type="hidden" class="form-control" id="id" name="tcu[{{$templatePlaceholder}}][id]"
                       value="<?=$templatePlaceholder?>">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input readonly type="text" class="form-control " name="tcu[{{$templatePlaceholder}}][name]"
                       value="{{ $item->receiver_id ?? '' }}">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input readonly type="text" class="form-control " name="tcu[{{$templatePlaceholder}}][name]"
                       value="{{ isset($item) ? $item->user->first_name . ' ' . $item->user->last_name : '' }}">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input readonly type="text" class="form-control " name="tcu[{{$templatePlaceholder}}][name]"
                       value="{{ $item->cmsUser->name ?? '' }}">
            </div>
        </div>
    </td>
</tr>
