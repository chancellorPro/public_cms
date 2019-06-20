@php
    $requestParams = $params ?? [];
@endphp

<a data-toggle="lightbox" data-max-width="900" href="{{ route($route, $requestParams) }}" title="@lang('Add')">
    <button class="btn btn-success btn-sm">
        <i class="fa fa-plus" aria-hidden="true"></i>
        @lang('Add')
    </button>
</a>
