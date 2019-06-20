<div id="common-block" class="form-container">
    <div class="x_panel user-debug-block">
        <div class="x_title">
            <h2>@lang('Common Data')</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <form method="PUT" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}

                @include('layouts.form-fields.input', ['model' => $user, 'name' => 'xp', 'inputType' => 'number'])
                @include('layouts.form-fields.input', ['model' => $user, 'name' => 'cash', 'inputType' => 'number'])
                @include('layouts.form-fields.input', ['model' => $user, 'name' => 'coins', 'inputType' => 'number'])
                
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-4">
                        @include('common.buttons.base', [
                            'name' => __('common.update'),
                            'btn_class' => 'btn-primary',
                            'class' => 'ajax-submit-action',
                            'route' => 'users.update',
                            'route_params' => ['id'=>$user->id, 'part'=>'common'],
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
