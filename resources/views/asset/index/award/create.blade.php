@include('common.buttons.create', [
    'route' => 'award.create',
    'name' => 'Award',
    'class' => 'award-create ajax-modal-action',
    'dataset' => [
        'header' => __('Create award'),
        'template-id' => $templateId,
        'template-placeholder' => $templatePlaceholder,
        'reload' => 0,
    ],
])
