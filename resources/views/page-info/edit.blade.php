<form method="POST" action="{{ route('page-info.update', ['route' => $model->id]) }}" class="form-horizontal">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    @include ('page-info.form', [
        'model' => $model,
    ])

    <div class="pull-right">
        @include('common.buttons.cancel')
        @include('common.buttons.save', [
            'route' => 'page-info.update',
            'route_params' => [
                'id' => $model->id,
            ],
            'dataset' => [
                'method' => 'PATCH',
                'reload' => 0
            ],
        ])
    </div>
</form>
