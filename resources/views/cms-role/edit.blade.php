@section('pageTitle', 'Edit Role')
@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('Edit CmsRole') #{{ $cmsRole->id }}</h3>
                </div>
                <div class="title_right"></div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <div class="x_panel">
                        <div class="x_content">
                            <a href="{{ route('cms-roles.index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> @lang('common.back')</button></a>
                            <br />
                            <br />

                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            <form method="POST" action="{{ route('cms-roles.update', ['id'=>$cmsRole->id]) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                {{ method_field('PATCH') }}
                                {{ csrf_field() }}

                                @include ('cms-role.form', ['submitButtonText' => __('common.update')])

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
