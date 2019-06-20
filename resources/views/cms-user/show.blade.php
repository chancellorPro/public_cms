@section('pageTitle', 'Show cms-user')
@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">cms-user {{ $cmsUser->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/cms-users') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/cms-users/' . $cmsUser->id . '/edit') }}" title="Edit cms-user"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('cms-users' . '/' . $cmsUser->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete cms-user" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $cmsUser->id }}</td>
                                    </tr>
                                    <tr><th> Login </th><td> {{ $cmsUser->login }} </td></tr><tr><th> Password </th><td> {{ $cmsUser->password }} </td></tr><tr><th> Name </th><td> {{ $cmsUser->name }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
