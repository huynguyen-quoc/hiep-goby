@if(isset($imageArtist) && count($imageArtist)> 0)
<div class="full-width bg-white col_padding_bottom">

    <div class="content">
        <div class="loader-container active" >
            <div class="content">
                <div class="gobyArtIcon spinner">S</div>
                <div class="icon-label">Loading</div>
            </div>
        </div>
        <div class="grid-masonry grid-model-list ">
            <div class="grid-column-size"></div>
            @foreach($imageArtist as $file)
                @if($file['file_group_type'] == 'ARTIST_IMAGE_TYPE')
                    <div class="masonry-brick">
                        <article class="image grid-item">
                            <div class="model-img-wrapper">
                                <a class="fancybox" href="{{asset('assets/upload/'.$file['artist_type'].'/'. $file['artist_name'].'/'.$file['file_name'])}}">
                                    <img alt="{{$file['file_title']}}" src="{{asset('assets/upload/'.$file['artist_type'].'/'. $file['artist_name'].'/'.$file['file_name'])}}"  >
                                </a>
                            </div>
                        </article>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
    <div class="text-center">
        <a class="button-more" href="/models">
            <span class="gobyArtIcon medium">F</span><br>Load More
        </a>
    </div>
</div>
@endif