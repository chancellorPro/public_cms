@if (!empty($item->actionType) && !empty($item->actionType->actionTypeState))
    @php
        $assetActionTypeAttributes = [];
        foreach ($item->assetActionTypeAttributes as $attr) {
            $assetActionTypeAttributes[$attr['action_type_state_id']][$attr['action_type_attribute_id']] = $attr['value'];
        }

        $assetStateAwards = [];
        foreach ($item->assetStateAward as $assetStateAward) {
            $assetStateAwards[$assetStateAward['action_type_state_id']] = $assetStateAward;
        }
    @endphp
    @foreach($item->actionType->actionTypeState as $actionTypeState)
        <div class="state">

            @if($actionTypeState->has_award)
                @include('asset.index.award.index')
            @endif

        @foreach($actionTypeState->actionTypeStateAttribute as $actionTypeStateAttribute)
            @if ($actionTypeStateAttribute->overridable
                    && $actionTypeStateAttribute->actionTypeAttribute->{'editable_on_' . $env})
                <div class="item">
                @php
                    $currentValue =
                        $assetActionTypeAttributes[$actionTypeState->id][$actionTypeStateAttribute->action_type_attribute_id] ??
                        $actionTypeStateAttribute->value ??
                        $actionTypeStateAttribute->actionTypeAttribute->default_value;

                    $inputName = 'actionTypeAttribute['.$actionTypeState->id.'][' . $actionTypeStateAttribute->action_type_attribute_id . ']';
                    $label = $actionTypeStateAttribute->actionTypeAttribute->name;
                @endphp
                @switch($actionTypeStateAttribute->actionTypeAttribute->type)
                    @case('bool')
                        @include('layouts.form-fields.bool', ['model' => null,'name' => $inputName,'selected' => $currentValue,'label' => $label,])
                        @break
                    @case('enum')
                        @include('layouts.form-fields.select2', [
                            'name' => $inputName,
                            'id' => 'id',
                            'label' => $label,
                            'value' => 'value',
                            'collection' => parsePossibleValues($actionTypeStateAttribute->actionTypeAttribute->possible_values),
                            'selected' => $currentValue,
                        ])
                        @break
                    @default
                        @include('layouts.form-fields.input', ['name' => $inputName,'label' => $label,'value' => $currentValue,])
                @endswitch
                </div>
            @endif
        @endforeach
        </div>
    @endforeach
@endif
