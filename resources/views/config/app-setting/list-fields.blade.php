@foreach($fields as $field => $fieldData)
    @php
        $fieldValue = $row[$field] ?? $embedFieldValue[$field] ?? '';
    @endphp

    @if(empty($namePrefix))
        <td class="editable">
    @endif

    @php
        $fieldName = empty($namePrefix) ? $field : $namePrefix . "[$field]";
        if(empty($namePrefix) && !empty($rowPrefix)) {
            $fieldName = empty($rowPrefix) ? $field : $rowPrefix . "[$rowIndex]" . "[$field]";
        }
        $nestingLevel = $nestingLevel ?? 1;
        $label = $nestingLevel == 1 ? false : __("forms.$config.$field");
    @endphp

    @switch($fieldData['list_type'])
        @case('hidden')
            <input type="hidden" name="{{$fieldName}}" value="{{$fieldValue}}">
        @break
        @case('string')
        @include('layouts.form-fields.input', ['name' => $fieldName, 'value' => $fieldValue, 'label'=> $label, 'placeholder' => $fieldData['placeholder'] ?? ''])
        @break

        @case('color')
        @include('layouts.form-fields.color', ['name' => $fieldName, 'value' => $fieldValue, 'label'=> $label, 'placeholder' => $fieldData['placeholder'] ?? ''])
        @break

        @case('int')
            <div style="width: 150px;float:right; display: inline-block">
                @include('layouts.form-fields.input', ['name' => $fieldName, 'value' => $fieldValue, 'inputType' => 'number', 'label'=> $label])
            </div>
        @break

        @case('datepicker')
        @include('layouts.form-fields.input', [
            'name' => $fieldName,
            'label' => false,
            'value' => $fieldValue,
            'class' => 'datepicker',
        ])
        @break

        @case('asset_preview')
            <div style="width: 200px;display: inline-block">
                @include('layouts.form-fields.input', ['name' => $fieldName, 'value' => $fieldValue, 'inputType' => 'number', 'label'=> $label])
                @include ('common.image.preview', [
                    'url' => $assets[$fieldValue]['preview_url'] ?? '',
                    'title' => $assets[$fieldValue]['name'] ?? '',
                    'placement' => 'right',
                    'box_title' => $assets[$fieldValue]['name'] ?? $fieldValue,
                    'size' => 100
                ])
            </div>
        @break

        @case('float')
        @include('layouts.form-fields.input', ['name' => $fieldName, 'value' => $fieldValue, 'inputType' => 'number', 'label'=> $label, 'attrs' => ['step' => 'any'] ])
        @break

        @case('bool')
        @include('layouts.form-fields.checkbox', [
            'name' => $fieldName,
            'value' => $fieldValue,
            'label'=> $label,
        ])
        @break

        @case('select')
        @include('layouts.form-fields.select2', [
            'name' => $fieldName,
            'collection' => $presetsData[$field]['forSelect'] ?? [],
            'id' =>'id',
            'value' =>'name',
            'selected' => $fieldValue,
            'label' => $label
        ])
        @break

        @case('selectGroup')
        @include('layouts.form-fields.select2', [
            'name' => $fieldName,
            'collectionGroups' => $presetsData[$field]['forSelect'] ?? [],
            'id' =>'id',
            'value' =>'name',
            'selected' => $fieldValue,
            'label' => $label
        ])
        @break

        @case('selectView')

        {{ $presetsData[$field]['forView'][$fieldValue] ?? $fieldValue }}
        @break

        @case('selectViewHidden')
            {{ $presetsData[$field]['forView'][$fieldValue] ?? $fieldValue }}
                <input type="hidden" name="{{$fieldName}}" value="{{$fieldValue}}">
        @break

        @case('embed')
        @include('config.app-setting.embed')
        @break

        @case('dropzone')
        @include('layouts.form-fields.dropzone', [
            'name' => $fieldName,
            'value' => $fieldValue,
            'label'=> $label,
        ])
        @break

        @case('award')
            @include('common.award.buttons', [
                'templateId' => 'award',
                'award_id' => $fieldValue ?? null,
                'fieldName' => $fieldName,
                'reload' => 0,
            ])


            @if (!empty($fieldValue) && !empty($awards[$fieldValue]))
                <div class="col-sm-8 col-sm-offset-4">
                    @include('common.award.info', [
                        'award' => $awards[$fieldValue],
                    ])
                </div>
            @endif
        @break

        @case('autoincrement')
            {{$fieldValue}}
            <input type="hidden" name="{{$fieldName}}" value="{{$fieldValue}}">
        @break

        @default
        {{$row[$field] ?? ''}}
        @break

    @endswitch


    @if(empty($namePrefix))
        </td>
    @endif
@endforeach


