@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('Edit Asset') #{{ $asset->id }}</h3>
                </div>
                <div class="title_right"></div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                    <div class="x_panel">
                        <div class="x_content">

                            @include('common.buttons.back', ['route' => 'assets.index'])

                            @if(!empty($asset->cmsAdp))
                                <a href="{{ route('cms-adps.edit', ['id'=>$asset->cmsAdp->id]) }}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        @lang('Adp source')
                                    </button>
                                </a>
                            @endif

                            <br />
                            <br />

                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            <form method="POST" action="{{ route('assets.update', ['id'=>$asset->id]) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                {{ method_field('PATCH') }}
                                {{ csrf_field() }}

                                @include ('asset.form', ['submitButtonText' => __('common.update')])

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
