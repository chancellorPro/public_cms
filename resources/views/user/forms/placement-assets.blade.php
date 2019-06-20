<div id="asset-container-{{ $placementId }}">
    <table class="table table-striped">
        <thead>
            <tr>
                <td>Asset Id</td>
                <td>Instance Id</td>
                <td>Name</td>
                <td>Created At</td>
                <td>Subtype</td>
                <td>Cash Price</td>
                <td>Coins Price</td>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $asset)
                <tr>
                    <td>
                        {{$asset->asset_id}}
                    </td>
                    <td>{{$asset->instance_id}}</td>
                    <td>
                        <div>{{$asset->asset->name}}</div>
                        @include('common.image.preview', [
                            'url' => $asset->asset->preview_url
                        ])
                    </td>
                    <td>{{$asset->created_at}}</td>
                    <td>{{ $subtypes[$asset->asset->subtype]->name ?? $asset->asset->subtype}}</td>
                    <td>{{$asset->asset->cash_price}}</td>
                    <td>{{$asset->asset->coins_price}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>