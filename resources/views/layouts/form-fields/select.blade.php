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
        <select autocomplete="off"
            {{ !empty($fieldId) ? "id=$fieldId" : "" }}
            name="{{ $formName ?? $name }}{{ !empty($mult) ? '[]' : '' }}"
            class="{{ !empty($manual_activation) ? 'manual' : ''}} {{ $class ?? '' }} form-control"
            {{ !empty($mult) ? 'multiple=""' : '' }}
            {{ !empty($attrs) ? implode(parameterizeArray($attrs), ' ') : '' }}
            >
            @if(!empty($addempty))
                <option value=""></option>
            @endif
            @foreach($collection as $item)
                @php
                    if (is_array($item)) {
                        $item = (object) $item;
                    }
                @endphp
            <option value="{{ $item->{$id} }}"
                    {{
                        ((!empty($mult) && $selected->contains($item->{$id})) ||
                        (empty($mult) && $selected == $item->{$id} && $selected !==''))
                        ? "selected" : ""
                    }} >
                        {{ $item->{$value} }}
            </option>
            @endforeach
        </select>
        {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
    </div>
</div>
