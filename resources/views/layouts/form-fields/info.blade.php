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
        <span class="form-control info {{ $class ?? '' }}">
            @if (isset($autoEscape) && $autoEscape === false)
                {!! $value ?? $model->{$name} ?? '' !!}
            @else
                {{ $value ?? $model->{$name} ?? '' }}
            @endif
        </span>
    </div>
</div>