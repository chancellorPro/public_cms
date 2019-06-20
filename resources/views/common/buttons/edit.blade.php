@include('common.buttons.base', [
    'name' => $name ?? __('Edit'),
    'fa_class' => $fa_class ?? 'fa-pencil-square-o',
    'btn_class' => $btn_class ?? 'btn-primary btn-sm',
    'class' => $class ?? 'ajax-modal-action',
])
