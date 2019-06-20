<tr id="row<?=$templatePlaceholder?>"
    data-id="<?=$templatePlaceholder?>">
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <span><?=$templatePlaceholder?></span>
                <input type="hidden" class="form-control" id="id" name="cu[{{$templatePlaceholder}}][id]"
                       value="<?=$templatePlaceholder?>"
                       placeholder="">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input readonly type="text" class="form-control " name="cu[{{$templatePlaceholder}}][name]" value="{{
                $item->name ?? '' }}" placeholder="">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input type="number" class="form-control " name="cu[{{$templatePlaceholder}}][limit]" value="{{
                $item->certConfig->limit ?? '' }}" placeholder="">
            </div>
        </div>
    </td>
    <td></td>
</tr>
