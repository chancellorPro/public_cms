@if (!empty($award->coins))
    @include('common.icons.coins', ['value' => $award->coins])
@endif
@if (!empty($award->cash))
    @include('common.icons.cash', ['value' => $award->cash])
@endif
@if (!empty($award->xp))
    @include('common.icons.xp', ['value' => $award->xp])
@endif

@if (!empty($award->assets))
    @foreach($award->assets as $asset)
        <img
            data-toggle="popover"
            data-placement="top"
            data-full="{{ Storage::url($asset->preview_url) }}"
            class="img-thumbnail img-xs"
            src="{{ Storage::url($asset->preview_url) }}"
            title="{{$asset->name}}">
    @endforeach
@endif
