<div class="row form-group {{ $errors->has($name) ? 'has-error' : ''}}">
    @if ((isset($label) && $label !== false) || !isset($label))
        <label {{ !empty($fieldId) ? "for=$fieldId" : "" }} class="col-md-4 control-label">
            @if (!empty($label))
                {{ __($label) }}
            @else
                @formFieldLabel($name)
            @endif
        </label>
    @endif
    
    <div class="@if (isset($label) && $label === false) col-md-12 @else col-md-6 @endif">
        <input
            type="{{ $inputType ?? 'text' }}"
            class="form-control {{ $class ?? '' }}"
            name="{{ $formName ?? $name }}"
            {{ !empty($fieldId) ? "id=$fieldId" : "" }}
            value="{{ old($name, $value ?? $model->{$name} ?? '') }}"
            {{ !empty($disabled) ? 'disabled' : '' }}
            placeholder="{{ $placeholder ?? '' }}"
            {{ !empty($attrs) ? implode(parameterizeArray($attrs), ' ') : '' }}
        >
        {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
    </div>
</div>
