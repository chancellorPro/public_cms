@php
    //single select with model
    if (empty($mult) && !empty($model))
    {
        $selected = old($name, $selected ?? $model->{$name} ?? '');
    }
    //single select without model
    elseif (empty($mult) && empty($model))
    {
        $selected = old($name, $selected ?? '');
    }
    //mult select
    elseif (!empty($mult))
    {
        $selected = old($name, $selected ?? collect([]));
    }
@endphp

<div class="row form-group {{ $errors->has($name) ? 'has-error' : ''}}">
    @if ((isset($label) && $label !== false) || !isset($label))
        <label class="col-md-4 control-label">
            @if (!empty($label))
                {{ $label }}
            @else
                @formFieldLabel($name)
            @endif
        </label>
    @endif
    <div class="@if (isset($label) && $label === false) col-md-12 @else col-md-6 @endif">
        @foreach($collection as $item)
            @php
                if (is_array($item)) {
                    $item = (object) $item;
                }
            @endphp
            @if ((!empty($mult) && $selected->contains($item->{$id})) ||
                    (empty($mult) && $selected == $item->{$id} && $selected !==''))
                    <p class="form-control info {{ $class ?? '' }}">
                        {{ $item->{$value} }}
                    </p>    
            @endif        
        @endforeach
    </div>
</div>