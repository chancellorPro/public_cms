@php
    //single select with model
    if (!empty($model))
    {
        $selected = old($name, $selected ?? $model->{$name} ?? '');
    }
    //single select without model
    else
    {
        $selected = old($name, $selected ?? '');
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
        <select
            {{ !empty($fieldId) ? "id=$fieldId" : "" }}
            name="{{ $formName ?? $name }}"
            class="select2 {{ $class ?? '' }} form-control"
            >
            @if(!empty($addempty))
                <option value=""></option>
            @endif
            
            <option value="1" {{ empty($selected) ? '' : 'selected' }}>@lang('Yes')</option>
            <option value="0" {{ !empty($selected) ? '' : 'selected' }}>@lang('No')</option>
        </select>
        {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
    </div>
</div>