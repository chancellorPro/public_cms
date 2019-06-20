@section('pageTitle', 'Cms-users')
@extends('layouts.app')

@section('main_container')
<div class="right_col">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Cms-users</h2></div>

                <ul class="nav nav-tabs deploy-tabs" id="deployTab" role="tablist">
                    <li class="nav-item @if($activeDirection == 'dev') active @endif">
                        <a class="nav-link" id="dev-tab" data-toggle="tab" href="#dev" role="tab" aria-controls="dev"
                           aria-selected="true">Dev</a>
                    </li>
                    <li class="nav-item @if($activeDirection == 'stage') active @endif">
                        <a class="nav-link" id="stage-tab" data-toggle="tab" href="#stage" role="tab" aria-controls="stage"
                           aria-selected="false">Stage</a>
                    </li>
                    <li class="nav-item @if($activeDirection == 'live') active @endif">
                        <a class="nav-link" id="live-tab" data-toggle="tab" href="#live" role="tab" aria-controls="live"
                           aria-selected="false">Live</a>
                    </li>
                </ul>

                <div class="card-body">
                    <a href="{{ url('/cms-users/create') }}" class="btn btn-success btn-sm" title="Add New cms-user">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New
                    </a>

                    @include('common.buttons.base', [
                        'route' => 'cms-users.sync',
                        'name' => __('Sync with stage'),
                        'fa_class' => 'fa-refresh',
                        'btn_class' => 'btn-primary btn-sm',
                        'class' => 'ajax-submit-action',
                        'dataset' => [
                            'method' => 'POST',
                            'dismiss' => 1,
                            'reload' => 1,
                        ],
                    ])

                    <form method="GET" action="{{ url('/cms-users') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                        <div class="input-group">
                            <span class="input-group-append">
                            <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <button class="form-control" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>

                    <br/>
                    <br/>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Login</th>
                                    <th>Email</th>
                                    <th>Name</th>

                                    <th>Link to the FB group</th>
                                    <th>Responsible Admin</th>
                                    <th>User id</th>
                                    <th>Total spent</th>
                                    <th>Tiara ID</th>
                                    <th>Trophy ID</th>
                                    <th>Trophy role</th>
                                    <th>Certificates role</th>
                                    <th>Prizes role</th>

                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cmsUsers as $item)
                                <tr>
                                    <td>{{ $loop->iteration or $item->id }}</td>
                                    <td>{{ $item->login }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->name }}</td>

                                    <td><a href="https://www.facebook.com/groups/{{ $item->fb_group_id }}">{{ $item->fb_group_id }}</a></td>
                                    <td>{{ !empty($item->responsiveAdmin) ?
                                    $item->responsiveAdmin->first_name . ' ' . $item->responsiveAdmin->last_name : '' }}</td>
                                    <td>{{ $item->user_id }}</td>
                                    <td>{{ isset($usersSpent[$item->user_id]) ? $usersSpent[$item->user_id] : 0 }}</td>
                                    <td>{{ $item->tiara }}</td>
                                    <td>{{ $item->trophy }}</td>
                                    <td>{{ $item->cmsRoles->contains(7) ? 'On' : 'Off' }}</td>
                                    <td>{{ $item->cmsRoles->contains(10) ? 'On' : 'Off' }}</td>
                                    <td>{{ $item->cmsRoles->contains(9) ? 'On' : 'Off' }}</td>

                                    <td>
                                        <a href="{{ url('/cms-users/' . $item->id) }}" title="View cms-user"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                        <a href="{{ url('/cms-users/' . $item->id . '/edit') }}" title="Edit cms-user"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                        {{-- Delete User btn --}}
                                        @include('common.buttons.delete', [
                                            'route' => 'cms-users.destroy',
                                            'route_params' => [
                                                'id' => $item->id,
                                            ],
                                            'dataset' => [
                                                'header' => __('Delete') . ' ' . $item->name,
                                            ],
                                            //'btn_class' => $btn_class ?? 'btn-danger btn-xs',
                                        ])
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $cmsUsers->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
