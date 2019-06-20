@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('Forbidden')</h3>
                </div>
                <div class="title_right">
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">

                            <div>
                                @lang('This section is forbidden for you')
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection