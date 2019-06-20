@can($route ?? '')
<a
    @if(!empty($route))
    href="{{ route($route, $route_params ?? []) }}"
    @endif
    title="{{ $name or '' }}"
    class="{{ $class or '' }}"
    id="{{ $id or '' }}"
    @if(!empty($dataset))
        @foreach($dataset as $dataKey => $dataValue)
            data-{{ $dataKey }}="{{ $dataValue }}"
        @endforeach
    @endif
>
    <button class="btn {{ $btn_class or '' }}">
        @if (!empty($btn_body))
            {!! $btn_body !!}
        @else
            <i class="fa {{ $fa_class or '' }}" aria-hidden="true"></i>
            {{ $name or '' }}
        @endif
    </button>
</a>
@endcan