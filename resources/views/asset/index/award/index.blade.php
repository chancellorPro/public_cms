@php
    $templateId = 'template-' . uniqid();
    $templatePlaceholder = '%award_id%';
@endphp

<div class="item">
    <template id="{{$templateId}}-edit">
        @include('asset.index.award.edit', [
            'id' => $templatePlaceholder,
        ])
        @include('asset.index.award.delete', [
            'templateId' => $templateId . '-create',
            'id' => $templatePlaceholder,
        ])
        <input type="hidden" name="assetStateAward[{{$actionTypeState->id}}]" value="{{$templatePlaceholder}}" />
    </template>
    <template id="{{$templateId}}-create">
        @include('asset.index.award.create', [
            'templateId' => $templateId . '-edit',
        ])
    </template>

    <div>
        @if(!empty($assetStateAwards[$actionTypeState->id]->award))
            @include('asset.index.award.edit', [
                'id' => $assetStateAwards[$actionTypeState->id]->award->id,
                'dataset' => [
                    'reload' => 1,
                ],
            ])
            @include('asset.index.award.delete', [
                'templateId' => $templateId . '-create',
                'id' => $assetStateAwards[$actionTypeState->id]->award->id,
            ])
        @else
            @include('asset.index.award.create', [
                'templateId' => $templateId . '-edit',
            ])
        @endif

        @if(!empty($assetStateAwards[$actionTypeState->id]->award))
            </div>
                @include('common.award.info', [
                    'award' => $assetStateAwards[$actionTypeState->id]->award,
                ])
            <div>
        @endif

    </div>
</div>