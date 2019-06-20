@include('common.buttons.base', [
    'name' => $name ?? __('Cancel'),
    'btn_class' => $btn_class ?? 'btn-default btn-sm',
    'dataset' => [
        'dismiss' => 'modal',
    ],
])
