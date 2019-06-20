@section('pageTitle', 'Edit cms-user')
@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Edit cms-user #{{ $cmsUser->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/cms-users') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/cms-users/' . $cmsUser->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('cms-user.form', ['submitButtonText' => 'Update'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
