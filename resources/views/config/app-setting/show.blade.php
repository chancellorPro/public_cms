@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('setting') {{ $setting->id }}</h3>
                </div>
                <div class="title_right"></div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                   
                    <div class="x_panel">
                        <div class="x_content">
                            <a href="{{ route('settings.index') }}" title="@lang('common.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('common.back')</button></a>
                            <a href="{{ route('settings.edit', ['id'=>$setting->id]) }}" title="Edit setting"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('common.edit')</button></a>

                            <form method="POST" action="{{ route('settings.destroy', ['id'=>$setting->id]) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="@lang('common.delete') setting" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('common.delete')</button>
                            </form>
                            <br/>
                            <br/>

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>@lang('common.id')</th><td>{{ $setting->id }}</td>
                                        </tr>
                                        <tr><th> Name </th><td> {{ $setting->name }} </td></tr><tr><th> Coins Price </th><td> {{ $setting->coins_price }} </td></tr><tr><th> Cash Price </th><td> {{ $setting->cash_price }} </td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
