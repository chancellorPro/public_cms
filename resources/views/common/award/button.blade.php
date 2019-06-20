@php
    $templateId = 'template-' . uniqid();
    $templatePlaceholder = '%award_id%';
    $buttonName = $buttonName ?? 'Award';
    $fieldName = $fieldName ?? 'award_id';
@endphp

<div class="row form-group">
    <div class="col-sm-8 col-sm-offset-4">
        <template id="{{$templateId}}-edit">
            @include('common.award.button.edit', [
                'id' => $templatePlaceholder,
            ])
            @include('common.award.button.delete', [
                'templateId' => $templateId . '-create',
                'buttonName' => $buttonName,
                'id' => $templatePlaceholder,
            ])
            <input type="hidden" name="{{$fieldName}}" value="{{$templatePlaceholder}}" />
        </template>
        <template id="{{$templateId}}-create">
            @include('common.award.button.create', [
                'reload' => $reload ?? null,
                'templateId' => $templateId . '-edit',
            ])
        </template>

        <div>
            @if(!empty($award_id))
                @include('common.award.button.edit', [
                    'id' => $award_id,
                ])
                @include('common.award.button.delete', [
                    'templateId' => $templateId . '-create',
                    'id' => $award_id,
                ])
                <input type="hidden" name="{{$fieldName}}" value="{{$award_id}}" />
            @else
                @include('common.award.button.create', [
                    'reload' => isset($reload) ? $reload : null,
                    'templateId' => $templateId . '-edit',
                ])
            @endif
        </div>
    </div>
</div>
