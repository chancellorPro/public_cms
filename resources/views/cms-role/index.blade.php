@section('pageTitle', 'Cms Roles')
@extends('layouts.app')

@section('main_container')
    <div class="right_col">
        <div>
            <div class="page-title">
                <div class="title_left">
                    <h3>@lang('Cms Roles')</h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <form method="GET" action="{{ route('cms-roles.index') }}" accept-charset="UTF-8" role="search">
                            <div class="input-group">
                                <input name="search" class="form-control" placeholder="@lang('common.search.placeholder')" type="text" value="{{ request('search') }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">@lang('common.search.go')</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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

            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  
                    <div class="x_panel">
                        <div class="x_content">
                            <a href="{{ route('cms-roles.create') }}" class="btn btn-success btn-sm" title="@lang('common.add') CmsRole">
                                <i class="fa fa-plus" aria-hidden="true"></i> @lang('common.add')
                            </a>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th><th>Name</th><th>Description</th><th>@lang('Actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cmsRoles as $item)
                                        <tr>
                                            <td>{{ $loop->iteration or $item->id }}</td>
                                            <td>{{ $item->name }}</td><td>{{ $item->description }}</td>
                                            <td>
                                                <a href="{{ route('cms-roles.show', ['id'=>$item->id]) }}" title="View CmsRole"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> @lang('View')</button></a>
                                                <a href="{{ route('cms-roles.edit', ['id'=>$item->id]) }}" title="Edit CmsRole"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> @lang('Edit')</button></a>

                                                <form method="POST" action="{{ route('cms-roles.destroy', ['id'=>$item->id]) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete CmsRole" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('Delete')</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper"> {!! $cmsRoles->appends(['search' => Request::get('search')])->render() !!} </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
