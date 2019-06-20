@include('common.buttons.edit', [
    'route' => $entity . '.edit',
    'route_params' => [
        'id' => $id,
    ],
    'dataset' => [
        'header' => $header ?? '',
    ],
    //'btn_class' => $btn_class ?? 'btn-primary btn-xs',
])
@include('common.buttons.delete', [
    'route' => $entity . '.destroy',
    'route_params' => [
        'id' => $id,
    ],
    'dataset' => [
        'header' => $header ?? '',
    ],
    //'btn_class' => $btn_class ?? 'btn-danger btn-xs',
])
