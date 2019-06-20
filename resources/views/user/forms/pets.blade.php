<div id="pets-block" class="form-container">
    <div class="x_panel user-debug-block">
        <div class="x_title">
            <h2>@lang('Pets')</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <form method="PUT" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}

                @foreach ($userPets as $userPet)
                    @include('layouts.form-fields.info', ['name' => 'pet', 'value' => $userPet->is_main ? __('MAIN') : $loop->iteration])
                    @include('layouts.form-fields.info', ['model' => $userPet, 'name' => 'placement_id'])
                    @include('layouts.form-fields.input', ['model' => $userPet, 'name' =>'name', 'formName' => 'pets[' . $userPet->placement_id . '][name]', 'label' => 'forms.users.name'])
                    @include('layouts.form-fields.input', ['model' => $userPet, 'name' =>'scale', 'formName' => 'pets[' . $userPet->placement_id . '][scale]', 'inputType' => 'number', 'label' => 'forms.users.scale'])
                    @include('layouts.form-fields.input', ['model' => $userPet, 'name' =>'color', 'formName' => 'pets[' . $userPet->placement_id . '][color]', 'label' => 'forms.users.color'])

                    <div class="divider-dashed"></div>
                @endforeach
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4">
                        @include('common.buttons.base', [
                            'name' => __('common.update'),
                            'btn_class' => 'btn-primary',
                            'class' => 'ajax-submit-action',
                            'route' => 'users.update',
                            'route_params' => ['id'=>$user->id, 'part'=>'pets'],
                            'dataset' => [
                                'method' => 'PUT',
                                'event' => 'SUBMIT_USER_PART_FORM',
                                'reload' => 0,
                            ]
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
