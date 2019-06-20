<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $cmsRole->name or ''}}" >
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="col-md-4 control-label">{{ 'Description' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="description" type="text" id="description" value="{{ $cmsRole->description or ''}}" >
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@foreach($permissions as $type => $sectionPermissions)
<table class="table tablestickyheader">
    @if($type == "unconfigured")
    <caption class="red">@lang('Unconfigured Pages. Tell the developers about it!')</caption>
    @endif
    <thead>
        <tr>
            <th>@lang('Page')</th>
            <th>@lang('common.page_actions.index')</th>
            <th>@lang('common.page_actions.create') / @lang('common.page_actions.store')</th>
            <th>@lang('common.page_actions.edit') / @lang('common.page_actions.update')</th>
            <th>@lang('common.page_actions.show')</th>
            <th>@lang('common.page_actions.destroy')</th>
            <th>@lang('Other')</th>
        </tr>    
    </thead>
    <tbody>   
        @foreach($sectionPermissions as $page => $actions)
        <tr>
            <td>{{ $page }}</td>
            <td>
                @if(isset($actions['index'])) 
                <input type="checkbox" name="permissions[]"  value="{{$actions['index']['id']}}"
                       {{ isset($cmsRole) && $cmsRole->getPermissionsList()->contains($actions['index']['id']) ? 'checked' : '' }} />
                @endif
            </td>
            <td>
                @if(isset($actions['create'])) 
                <input type="checkbox" name="permissions[]"  value="{{$actions['create']['id']}}"
                       {{ isset($cmsRole) && $cmsRole->getPermissionsList()->contains($actions['create']['id']) ? 'checked' : '' }} />
                @endif
                
                @if(isset($actions['store'])) 
                <span>/</span>
                <input type="checkbox" name="permissions[]"  value="{{$actions['store']['id']}}"
                       {{ isset($cmsRole) && $cmsRole->getPermissionsList()->contains($actions['store']['id']) ? 'checked' : '' }} />
                @endif
            </td>
            <td>
                @if(isset($actions['edit'])) 
                <input type="checkbox" name="permissions[]"  value="{{$actions['edit']['id']}}"
                       {{ isset($cmsRole) && $cmsRole->getPermissionsList()->contains($actions['edit']['id']) ? 'checked' : '' }} />
                @endif
                
                @if(isset($actions['update'])) 
                <span>/</span>
                <input type="checkbox" name="permissions[]"  value="{{$actions['update']['id']}}"
                       {{ isset($cmsRole) && $cmsRole->getPermissionsList()->contains($actions['update']['id']) ? 'checked' : '' }} />
                @endif
            </td>
           
            <td>
                @if(isset($actions['show'])) 
                <input type="checkbox" name="permissions[]"  value="{{$actions['show']['id']}}"
                       {{ isset($cmsRole) && $cmsRole->getPermissionsList()->contains($actions['show']['id']) ? 'checked' : '' }} />
                @endif
            </td>
            <td>
                @if(isset($actions['destroy'])) 
                <input type="checkbox" name="permissions[]"  value="{{$actions['destroy']['id']}}"
                       {{ isset($cmsRole) && $cmsRole->getPermissionsList()->contains($actions['destroy']['id']) ? 'checked' : '' }} />
                @endif
            </td>
            <td>
                @if(!empty($actions))
                    @php  
                        unset($actions['destroy'], 
                            $actions['show'], 
                            $actions['store'], 
                            $actions['update'], 
                            $actions['edit'], 
                            $actions['create'], 
                            $actions['index']) 
                    @endphp
                    
                    @foreach($actions as $actionName => $action)
                        {{$action['name']}}
                        <input type="checkbox" name="permissions[]"  value="{{$action['id']}}"
                            {{ isset($cmsRole) && $cmsRole->getPermissionsList()->contains($action['id']) ? 'checked' : '' }} />
                        <br>
                    @endforeach
                @endif
            </td>
        </tr>
        @endforeach
        
</tbody>
</table>
@endforeach

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or __('common.create') }}">
    </div>
</div>
