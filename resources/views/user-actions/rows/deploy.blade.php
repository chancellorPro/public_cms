<tr>
    <td>{{ $row->id }}</td>
    <td>{{ $row->cmsUser->name }}</td>
    <td>@lang('cms-action-history.sources.' . $row->source)</td>
    <td>@lang('cms-action-history.actions.' . $row->action)</td>
    <td>@lang('Message'): {{ $row->data['message'] }}</td>
    <td>{{ $row->created_at }}</td>
</tr>