@php
    $defaultReload = $reload ?? 1;
@endphp
@include('common.buttons.create', [
    'route' => 'award.create',
    'name' => $buttonName,
    'class' => 'award-create-button ajax-modal-action',
    'dataset' => [
        'header' => __('Create award'),
        'template-id' => $templateId,
        'template-placeholder' => $templatePlaceholder,
        'event' => 'AWARD_DELETE',
        'reload' => $defaultReload,
    ],
])
