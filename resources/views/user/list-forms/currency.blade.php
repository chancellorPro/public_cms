<div id="list-currency-block" class="form-container">
    <div>
    <form method="PUT">
        <table>
            <tr>
                <td>
                    @include('layouts.form-fields.input', ['model' => $user, 'name' => 'cash', 'inputType' => 'number'])
                    @include('layouts.form-fields.input', ['model' => $user, 'name' => 'coins', 'inputType' => 'number'])
                </td>
                <td>
                    @include('common.buttons.base', [
                        'name' => __('common.save'),
                        'btn_class' => 'btn-sm btn-success',
                        'class' => 'ajax-submit-action',
                        'route' => 'users.update',
                        'route_params' => ['id'=>$user->id, 'part'=>'currencyFromList'],
                        'dataset' => [
                            'method' => 'PUT',
                            'event' => 'SUBMIT_USER_PART_FORM',
                            'reload' => 0,
                        ]
                    ])
                </td>
            </tr>
        </table>
    </form>
    </div>

    <div>
    <form method="PUT">
        <table>
            <tr>
                <td>
                    @include('layouts.form-fields.input', ['name' => 'cash', 'inputType' => 'number'])
                    @include('layouts.form-fields.input', ['name' => 'coins', 'inputType' => 'number'])
                </td>
                <td>
                    @include('common.buttons.base', [
                        'name' => __('Add'),
                        'btn_class' => 'btn-sm btn-success',
                        'class' => 'ajax-submit-action',
                        'route' => 'users.update',
                        'route_params' => ['id'=>$user->id, 'part'=>'addCurrencyFromList'],
                        'dataset' => [
                            'method' => 'PUT',
                            'event' => 'SUBMIT_USER_PART_FORM',
                            'reload' => 0,
                        ]
                    ])
                </td>
            </tr>
        </table>
    </form>
    </div>
</div>
