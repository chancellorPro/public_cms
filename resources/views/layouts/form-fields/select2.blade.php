@php
    if (empty($class)) {
        $class = 'select2';
    } else {
        $class .= ' select2';
    }
@endphp
@include('layouts.form-fields.select')