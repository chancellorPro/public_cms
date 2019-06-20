 <div class="form-horizontal">

    @foreach($configurableAttributes[$item->subtype] ?? [] as $attributeId => $configAttribute)
        @php
            $attribute = $attributes[$attributeId];
            $itemAttributes = $item->assetAttributes->keyBy('pivot.attribute_id');
            $attributeValue = $itemAttributes[$attributeId]->pivot->value ?? $attributeValues[$item->subtype][$attributeId] ?? $attribute->default_value ?? '';
        @endphp

        @if($attribute->{'editable_on_' . $env})
             <div class="state">
                 <div class="item">

            @switch($attributes[$attributeId]->type)
                @case('bool')
                    @include('layouts.form-fields.checkbox', [ 'name' => "attributes[{$attribute->id}]", 'label' => "#{$attribute->id} {$attribute->name}", 'value' => $attributeValue ])
                    @break
                @case('enum')
                    @include('layouts.form-fields.select2', [
                        'name' => "attributes[{$attribute->id}]",
                        'collection' => parsePossibleValues($attribute->possible_values),
                        'id' => 'id',
                        'value' => 'value',
                        'selected' => $attributeValue,
                        'label' => "#{$attribute->id} {$attribute->name}"
                    ])
                    @break
                @default
                    @include('layouts.form-fields.input', [ 'name' => "attributes[{$attribute->id}]", 'label' => "#{$attribute->id} {$attribute->name}", 'value' => $attributeValue ])
            @endswitch

                 </div>

             </div>
         @endif
    @endforeach

</div>
