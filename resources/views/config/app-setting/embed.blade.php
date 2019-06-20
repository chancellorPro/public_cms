@php
    $embedBlockId = $embedBlockId ?? uniqid();
    $idPlaceholder = "%id$nestingLevel%";
@endphp
<div class="embed">
    @if (!empty($label))
        <div class="row">
            <div class="col-md-12">
                <label>{{$label}}</label>
            </div>
        </div>
    @endif

    <div class="row">
        <div id="{{$field}}-embed-{{$embedBlockId}}" class="col-md-12 embed-{{ $fieldData['embed_style'] or 'row' }}">
            @if(!empty($fieldValue))
                @foreach($fieldValue as $rowId => $embedfieldValue)
                    @if(!empty($embedfieldValue))
                        <div class="embed-group {{ $nestingLevel > 1 ? ' gray' : ''}}">
                            @include ('config.app-setting.list-fields', ['fields' => $fieldData['embed'], 'nestingLevel' => $nestingLevel + 1, 'embedBlockId' => null,  'row' => [], 'embedFieldValue' => $embedfieldValue, 'namePrefix' => $fieldName . "[$rowId]"])

                            @if(empty($fieldData['single_row']))
                                <a class="remove-embed close" data-target="{{$field}}-embed-{{$embedBlockId}}">
                                    <span>×</span>
                                </a>
                            @endif
                        </div>
                    @endif
                @endforeach
            @elseif(!empty($fieldData['create_row']))
                @include ('config.app-setting.list-fields', ['fields' => $fieldData['embed'], 'nestingLevel' => $nestingLevel + 1, 'embedBlockId' => null,  'row' => [], 'embedFieldValue' => [], 'namePrefix' => $fieldName . "[0]"])

                @if(empty($fieldData['single_row']))
                    <a class="remove-embed close" data-target="{{$field}}-embed-{{$embedBlockId}}">
                        <span>×</span>
                    </a>
                @endif
            @endif
        </div>
    </div>

    {{-- Template --}}
    @if(empty($fieldData['single_row']))
        <div class="row">
            <div class="col-md-12">
                <div class="embed-buttons{{ $nestingLevel > 1 ? ' gray' : ''}}">
                    <button class="btn btn-success btn-xs add-embed" data-target="{{$field}}-embed-{{$embedBlockId}}" data-rowid="{{$rowId ?? 0}}" data-idplacepolder="{{$idPlaceholder}}" data-template="{{$field}}-template-{{$embedBlockId}}">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        @lang('common.add_row')
                    </button>
                </div>
            </div>
        </div>

        <template id="{{$field}}-template-{{$embedBlockId}}">
            <div class="embed-group {{ $nestingLevel > 1 ? ' gray' : ''}}">
                @include ('config.app-setting.list-fields', ['fields' => $fieldData['embed'], 'nestingLevel' => $nestingLevel + 1, 'embedBlockId' => '%embedBlockId%', 'row' => [], 'embedFieldValue' => [], 'namePrefix' => $fieldName . "[$idPlaceholder]"])
                <a class="remove-embed close" data-target="{{$field}}-embed-{{$embedBlockId}}">
                    <span>×</span>
                </a>
            </div>
        </template>
    @endif

</div>
