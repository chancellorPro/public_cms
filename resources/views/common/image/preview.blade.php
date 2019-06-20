<div class="list-thumbnail img-preview"
     data-toggle="popover"
     data-placement="{{ $placement ?? 'top' }}"
     title="{{ $box_title ?? '' }}"
     data-full="{{ Storage::url($url) }}"
>
    <img class="img-responsive {{ $url ? '' : 'no-img' }}"
         src="{{ $url ? Storage::url($url) : '' }}"
         title="{{ $title or '' }}"
    />
</div>
