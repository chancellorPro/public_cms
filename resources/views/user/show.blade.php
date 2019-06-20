@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('User') {{ $user->id }}</h3>
                </div>
                <div class="title_right"></div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                   
                    <div class="x_panel">
                        <div class="x_content">
                            <a href="{{ route('users.index') }}" title="@lang('common.back')"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('common.back')</button></a>
                            <a href="{{ route('users.edit', ['id'=>$user->id]) }}" title="Edit User"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('common.edit')</button></a>

                            <form method="POST" action="{{ route('users.destroy', ['id'=>$user->id]) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="@lang('common.delete') User" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('common.delete')</button>
                            </form>
                            <br/>
                            <br/>

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>@lang('common.id')</th><td>{{ $user->id }}</td>
                                        </tr>
                                        <tr><th> Xp </th><td> {{ $user->xp }} </td></tr><tr><th> Cash </th><td> {{ $user->cash }} </td></tr><tr><th> Coins </th><td> {{ $user->coins }} </td></tr>
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
