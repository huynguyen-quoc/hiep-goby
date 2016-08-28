<div class="full-width bg-white col_padding_bottom">
    <div class="content">
        <div class="headbox">
            <span class="text_left text-uppercase">Nghệ Sĩ Quan Tâm</span>
        </div>
        <hr />
        @if(isset($artists) && count($artists) > 0)
            <div class="loader-container active" >
                <div class="content">
                    <div class="gobyArtIcon spinner">S</div>
                    <div class="icon-label">Đang Tải</div>
                </div>
            </div>
            <div class="grid-masonry grid-model-list touch-item-wrapper">
                <div class="grid-column-size"></div>

                @foreach($artists as $artist)
                    <div class="masonry-brick touch-item">
                        <article class="model grid-item  touch-item {{ isset($artist['added_cart']) && $artist['added_cart'] == true ? 'wishlist' : '' }}" data-artist="{{ base64_encode(json_encode($artist)) }}">
                            <a href="/nghe-si/{{ $artist['artist_slug'] }}"  >
                                <div class="model-img-wrapper model-background-img-wrapper"
                                     style="background-image: url({{ asset('assets/upload/'.$artist['artist_type_slug'].'/'. $artist['artist_slug'].'/'. $artist['artist_avatar'])}})">
                                    <div class="model-name-box">
                                        <span class="model-name" data-name="{{ $artist['artist_full_name'] }}"></span>
                                    </div>

                                    <div class="wishlist-icon-wrapper in-wishlist" >
                                        <div class="">
                                            {{--<span class="model-is-active gobyArtIcon">D</span>--}}
                                            <span class="gobyArtIcon">S</span>
                                        </div>
                                    </div>
                                    <div class="wishlist-toggle-wrapper">
                                        <div class="in-wishlist">
                                            <span class="icon-label s_hidden">Shortlist remove</span>
                                            <span class="icon-label l_hidden m_hidden">Shortlist -</span>
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
                                   {{ $artist['artist_full_name'] }}
                                    </span>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            @else
                <div >
                    <div><br>Không tìm thấy kết quả!</div>
                </div>
                <div class="grid-masonry  grid-model-list">
                </div>
            @endif

        </div>
    </div>
</div>