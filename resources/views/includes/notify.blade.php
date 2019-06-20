
<script type="text/javascript">
    


@foreach (getNotify() as $type => $messages)
    @foreach ($messages as $message)
        $(document).ready(function(){
            $.notify({
                message: '{{$message}}'
            },{
                type: '{{$type}}'
            });
        })

    @endforeach
@endforeach

</script>