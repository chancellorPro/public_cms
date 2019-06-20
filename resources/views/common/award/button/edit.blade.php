@include('common.buttons.edit', [
    'route' => 'award.edit',
    'route_params' => [
        'id' => $id,
    ],
    'name' => 'Award',
    'dataset' => [
        'header' => "[ID:$id] " . __('Edit award'),
    ],
])
