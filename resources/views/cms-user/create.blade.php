@section('pageTitle', 'Create cms-user')
@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Create New cms-user</div>
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

                        <form method="POST" action="{{ url('/cms-users') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('cms-user.form', [
                                'cmsUser' => null,
                            ])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
