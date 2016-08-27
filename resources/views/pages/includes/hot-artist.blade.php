@if(isset($artistHot) && count($artistHot)> 0)
<div class="full-width bg-white">
    <div class="content">
        <div class="headbox">
            <span class="text_left text-uppercase">Nghệ Sĩ Tiêu Biểu</span>
        </div>
        <div class="loader-container active" >
            <div class="content">
                <div class="gobyArtIcon spinner">S</div>
                <div class="icon-label">Loading</div>
            </div>
        </div>
        <hr class="divider">
        <div class="grid-masonry touch-item-wrapper">
            <div class="grid-column-size"></div>

                @foreach($artistHot as $artist)
                    <div class="masonry-brick touch-item">
                        <article class="model grid-item {{ isset($artist['added_cart']) && $artist['added_cart'] == true ? 'wishlist' : '' }}" data-artist="{{ base64_encode(json_encode($artist)) }}">
                            <a href="/nghe-si/{{ $artist['artist_slug'] }}"  >
                                <div class="model-img-wrapper model-background-img-wrapper"
                                     style="background-image: url({{ asset('assets/upload/'.$artist['artist_type_slug'].'/'. $artist['artist_slug'].'/'. $artist['artist_avatar'])}})">
                                    <div class="model-name-box">
                                        <span class="model-name" data-name="{{ $artist['artist_name'] }}"></span>
                                    </div>

                                    <div class="wishlist-icon-wrapper in-wishlist" >
                                        <div class="">
                                            <span class="model-is-active gobyArtIcon">D</span>
                                            <span class="gobyArtIcon">S</span>
                                        </div>
                                    </div>

                                    <div class="wishlist-toggle-wrapper">
                                        <div class="in-wishlist">
                                            <span class="icon-label s_hidden">Shortlist remove</span>
                                            <span class="icon-label l_hidden m_hidden">Shortlist </span>
                                            <span class="sofaIcon l_hidden m_hidden">D</span>
                                            <span class="button-loading">Adding to cart...</span>
                                        </div>
                                        <div class="not-in-wishlist">
                                            <span class="icon-label s_hidden">Add to shortlist</span>
                                            <span class="icon-label l_hidden m_hidden">Shortlist +</span>
                                            <span class="button-loading">Adding to cart...</span>
                                        </div>
                                    </div>

                                </div>
                            </a>
                            <div class="model-name-wrapper">
                                <a href="#">
                                    <span class="model-name ">
                                      Kim Ngan
                                    </span>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach


        </div>
    </div>
    <div class="text-center">
        <a class="button-more" href="/models">
            <span class="gobyArtIcon medium">F</span><br>See all
        </a>
    </div>
</div>
@endif
