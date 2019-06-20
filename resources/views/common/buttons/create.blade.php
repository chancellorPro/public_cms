@include('common.buttons.base', [
    'name' => $name ?? __('Create'),
    'fa_class' => $fa_class ?? 'fa-plus',
    'btn_class' => $btn_class ?? 'btn-success btn-sm',
    'class' => $class ?? 'ajax-modal-action',
])
