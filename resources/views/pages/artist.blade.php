@extends("layout.master")
@section("content")
    <div class="model model-detail">
        <div class="full-width bg-grey">
            <div class="content with-bottom-padding">
                <div class="headbox">
                    <div class="rel-container">
                        <div class="model-back-link s_hidden">
                            <a href="" ><span class="gobyArtIcon">;</span></a>
                        </div>
                        <span class="model-detail-name">birthe harms</span>
                    </div>
                </div>
                <div class="controls s_hidden m_hidden">
                    <ul>
                        <li>
                            <a href="#">
                                <div class="in-wishlist">
                                    Remove from wishlist
                                </div>
                                <div class="not-in-wishlist">
                                    Add to shortlist
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>


                <div class="model-info">
                    <div class="model-info-col-1">
                        <div class="model-info-detail">
                            <span class="model-detail-label">Height</span>
                            <span class="model-detail-value" >180 cm/5'11"</span>
                        </div>
                        <div class="model-info-detail">
                            <span class="model-detail-label">bust</span>
                            <span class="model-detail-value">77 cm/30.5"</span>
                        </div>
                        <div class="model-info-detail">
                            <span class="model-detail-label">Waist</span>
                            <span class="model-detail-value">60 cm/23.5"</span>
                        </div>
                        <div class="model-info-detail">
                            <span class="model-detail-label">Hips</span>
                            <span class="model-detail-value">89 cm/35"</span>
                        </div>
                    </div>

                    <div class="model-info-col-2">
                        <div class="model-info-detail">
                            <span class="model-detail-label">Dress</span>
                            <span class="model-detail-value">34 eu/4 us/6 uk</span>
                        </div>
                        <div class="model-info-detail">
                            <span class="model-detail-label">Shoes</span>
                            <span class="model-detail-value">42 EU/11 US/7.5 UK</span>
                        </div>
                        <div class="model-info-detail">
                            <span class="model-detail-label">Hair</span>
                            <span class="model-detail-value">Darkblond</span>
                        </div>
                        <div class="model-info-detail">
                            <span class="model-detail-label">Eyes</span>
                            <span class="model-detail-value">Blue/Green</span>
                        </div>
                    </div>

                </div>


            </div>
        </div>
        @include("pages.includes.artist-content")
        @include("pages.includes.video")
        <div class="model-detail-parallax-wrapper with-top-padding">
         <div id="model-portrait-image" class="portrait-image-container-inner parallax parallax-spacer"
              style="min-height: 800px;
                      background-image: url({{asset('assets/images/parallax/1.jpg')}});
                      background-position: 50% -557.5px;">

         </div>
    </div>
@stop()
@section("scripts")
    <script type="text/javascript">
        var scrollParallaxPortraitImage=function(){
            var el=$('#model-portrait-image');
            var speed=0.5;
            var bgPositionOffsetY = 0;
            var newPositionY=bgPositionOffsetY;

            if(el.length>0){
                if(window.parallaxScrollEnabled){
                    var windowHeight=$(window).height();
                    var top = el.offset().top;
                    var scrollY = $(window).scrollTop();
                    if( scrollY + windowHeight + 100 > top && top - windowHeight - 100 < scrollY){
                        distance = scrollY - top;
                        newPositionY=(bgPositionOffsetY - distance * speed);
                    }
                }

                elBackgrounPos = "50% " + newPositionY+"px";
                el.css({backgroundPosition: elBackgrounPos});
            }
        }
        $(function () {
            $('body').toggleClass('artist');

            scrollParallaxPortraitImage();

            $(window).scroll (
                function() {scrollParallaxPortraitImage();
            });

            $('.grid-masonry').masonry({
                columnWidth: '.grid-column-size',
                itemSelector: '.masonry-brick',
                percentPosition: true
            });

            $('.video-content').on('click', 'a.video-slider-image-wrapper', function(){
                var $this = $(this);
                $this.fadeOut();
                var src = $this.attr('data-src');
                if (src.indexOf("?") >= 0){
                    src += "&";
                } else{
                    src += "?";
                }
                src += "autoplay=1";

                $this.replaceWith('<iframe  src="'+src+'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
            });

            $("#video-slider").slick({
                slidesToScroll: 1,
                slidesToShow: 2,
                variableWidth: false,
                autoplay: false,
                fade: false,
                dots: false,
                pauseOnHover: false,
                arrows: true,
                draggable: false,
                infinite:false,
                responsive: [
                {
                    breakpoint: 640,
                    settings:{
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]

            });
        })


    </script>
@stop()