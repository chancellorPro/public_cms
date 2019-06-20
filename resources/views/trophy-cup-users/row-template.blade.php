<tr id="row<?=$templatePlaceholder?>"
    data-id="<?=$templatePlaceholder?>">
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <span><?=$templatePlaceholder?></span>
                <input type="hidden" class="form-control" id="id" name="tcu[{{$templatePlaceholder}}][id]"
                       value="<?=$templatePlaceholder?>"
                       placeholder="">
            </div>
        </div>
    </td>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input readonly type="text" class="form-control " name="tcu[{{$templatePlaceholder}}][name]" value="{{
                $item->name ?? '' }}" placeholder="">
            </div>
        </div>
    </td>
    <td>
        {{-- Asset ID --}}
        @include('layouts.form-fields.input', [
            'class' => 'asset-id',
            'name' => "tcu[{$templatePlaceholder}][asset_id]",
            'label' => false,
            'inputType' => 'number',
            'value' => $item->trophyCupConfig->asset_id ?? '',
        ])
        @if(isset($item->trophyCupConfig->asset_id) && !empty($item->trophyCupConfig->assetId->preview_url))
            <div class="list-thumbnail" data-toggle="popover"
                 data-full="{{ Storage::url($item->trophyCupConfig->assetId->preview_url) }}">
                <img class="img-responsive" src="{{ Storage::url($item->trophyCupConfig->assetId->preview_url) }}"
                     title="{{$item->trophyCupConfig->assetId->name}}">
            </div>
        @endif
    </td>
    <td>
        <div class="row form-group">
            <div class=" col-md-12 ">
                <input type="number" class="form-control " name="tcu[{{$templatePlaceholder}}][limit]" value="{{
                $item->trophyCupConfig->limit ?? '' }}" placeholder="">
            </div>
        </div>
    </td>
    <td></td>
</tr>
