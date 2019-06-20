@php
$id = uniqid();
@endphp
<div id="carousel-{{ $id }}" class="carousel slide">

    <!-- Carousel items -->
    <div class="carousel-inner">
        <div class="item active">
            <div class="row">
                @foreach($images as $image)
                <div 
                    class="col-sm-4" 
                    @if(isset($height))
                        style="height: {{ $height }}px;"
                    @endif
                    >
                    <a href="{{ Storage::url($image->{$url}) }}" data-toggle="lightbox" data-gallery="gallery-{{ $id }}">
                        <img src="{{ Storage::url($image->{$url}) }}" alt="{{ $image->{$name} }}" title="{{ $image->{$name} }}" class="img-responsive">
                    </a>
                </div>

                @if ($loop->iteration % 3 == 0 && !$loop->last)
            </div>
        </div>
        <div class="item">
            <div class="row">
                @endif

                @if ($loop->last)
            </div>
        </div>
        @endif

        @endforeach
    </div>
    <!--/carousel-inner--> 
    @if (count($images) > 3)
        <a class="left carousel-control" href="#carousel-{{ $id }}" data-slide="prev">‹</a>
        <a class="right carousel-control" href="#carousel-{{ $id }}" data-slide="next">›</a>
    @endif
</div>