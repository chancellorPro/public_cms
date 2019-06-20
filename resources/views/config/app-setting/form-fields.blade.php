
@foreach($fields as $field => $fieldData)
    @php
        $fieldName = empty($namePrefix) ? $field : $namePrefix . "[$field]";
        $nestingLevel = $nestingLevel ?? 1;
    @endphp
    @switch($fieldData['create_type'])
        @case('string')
            @include('layouts.form-fields.input', ['name' => $fieldName, 'value' => '', 'label'=> __("forms.$config.$field"), 'placeholder' => $fieldData['placeholder'] ?? ''])
        @break
        @case('color')
            @include('layouts.form-fields.color', ['name' => $fieldName, 'value' => '', 'label'=> __("forms.$config.$field"), 'placeholder' => $fieldData['placeholder'] ?? ''])
        @break
        @case('int')
            @include('layouts.form-fields.input', ['name' => $fieldName, 'value' => '', 'inputType' => 'number', 'label'=> __("forms.$config.$field")])
        @break
        @case('float')
            @include('layouts.form-fields.input', ['name' => $fieldName, 'value' => '', 'inputType' => 'number', 'label'=> __("forms.$config.$field"), 'attrs' => ['step' => 'any'] ])
        @break
        @case('bool')
            @include('layouts.form-fields.bool', ['name' => $fieldName, 'label'=> __("forms.$config.$field")])
        @break
        
        @case('select')
            @include('layouts.form-fields.select2', [
                'name' => $fieldName,
                'collection' => $presetsData[$field]['forSelect'] ?? [],
                'id'=>'id',
                'value'=>'name',
                'label'=> __("forms.$config.$field")
            ])
        @break
        @case('selectGroup')
        @include('layouts.form-fields.select2', [
            'name' => $fieldName,
            'collectionGroups' => $presetsData[$field]['forSelect'] ?? [],
            'id'=>'id',
            'value'=>'name',
            'label'=> __("forms.$config.$field")
        ])
        @break
        @case('embed')
            @php
                $embedBlockId = $embedBlockId ?? uniqid();
                $idPlaceholder = "%id$nestingLevel%";
            @endphp 
            
            <div class="form-group">
                <label class="col-md-4 control-label">
                    @lang("forms.$config.$field")
                </label>
                <div id="{{$field}}-embed-{{$embedBlockId}}" class="col-md-6">
                    <!--TODO: $emptyEmbedRow not implemented-->
                    @if(!empty($fieldData['create_row']))
                    <div class="embed-group">
                        @include ('config.app-setting.form-fields', ['fields' => $fieldData['embed'], 'embedBlockId' => null, 'namePrefix' => $fieldName . '[0]', 'nestingLevel' => $nestingLevel + 1])
                        
                        @if(empty($fieldData['single_row']))
                            <a class="remove-embed" data-target="{{$field}}-embed-{{$embedBlockId}}" href="javascript:void(0);">
                                <button class="btn btn-danger btn-sm btn-circle"><i class="fa fa-close" aria-hidden="true"></i> </button>
                            </a>
                        @endif
                        
                    </div>
                    @endif
                </div>
                
                @if(empty($fieldData['single_row']))
                    <label class="col-md-4 control-label"></label>
                    <a class="col-md-4 add-embed" data-target="{{$field}}-embed-{{$embedBlockId}}" data-idplacepolder="{{$idPlaceholder}}" data-template="{{$field}}-template-{{$embedBlockId}}" data-rowid="0" href="javascript:void(0);">
                        <button class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> @lang('common.add_row')</button>
                    </a>

                    <template id="{{$field}}-template-{{$embedBlockId}}">
                        <div class="embed-group">
                            <div class="divider-dashed"></div>
                            @include ('config.app-setting.form-fields', ['fields' => $fieldData['embed'], 'embedBlockId' => '%embedBlockId%', 'namePrefix' => $fieldName . "[$idPlaceholder]", 'nestingLevel' => $nestingLevel + 1])
                            <a class="remove-embed" data-target="{{$field}}-embed-%embedBlockId%" href="javascript:void(0);">
                                <button class="btn btn-danger btn-sm btn-circle"><i class="fa fa-close" aria-hidden="true"></i> </button>
                            </a>
                        </div>
                    </template>
                @endif
                
            </div>
        @break
    @endswitch

@endforeach
