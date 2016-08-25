@extends("layout.master")
@section("meta")
    @if(isset($siteOptions))
        <meta name="keywords" content="{{!isset($siteOptions['SITE_KEYWORD']) ? '' :$siteOptions['SITE_KEYWORD']}}">
        <meta name="description" content="{{!isset($siteOptions['SITE_DESCRIPTION']) ? '' : $siteOptions['SITE_DESCRIPTION']}}">
        <meta name="copyright" content="{{!isset($siteOptions['SITE_COPYRIGHT']) ? '' : $siteOptions['SITE_COPYRIGHT']}}">
        <meta name="author" content="{{!isset($siteOptions['SITE_AUTHOR']) ? '' : $siteOptions['SITE_AUTHOR']}}">
        <meta name="robots" content="all">
    @endif
@endsection
@section("content")
    <div class="model model-detail">
        <div class="full-width bg-grey">
            <div class="content with-bottom-padding">
                <div class="headbox">
                    <div class="rel-container">
                        <div class="model-back-link s_hidden">
                            <a href="" onclick="    window.history.back();"><span class="gobyArtIcon">;</span></a>
                        </div>
                        <span class="model-detail-name">{{ isset($artistDetail) ? $artistDetail['artist_full_name'] : '' }}</span>
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

                @if(isset($artistExtra1) && count($artistExtra1) > 0 && isset($artistExtra2) && count($artistExtra2) > 0)
                    <div class="model-info">
                        <div class="model-info-col-1">
                            @for($i = 0; $i < count($artistExtra1); $i++)
                                <div class="model-info-detail">
                                    <span class="model-detail-label">{{$artistExtra1[$i]['title']}}</span>
                                    <span class="model-detail-value">{{$artistExtra1[$i]['value']}}</span>
                                </div>
                            @endfor
                        </div>

                        <div class="model-info-col-2">
                            @for($i =0; $i < count($artistExtra2); $i++)
                                <div class="model-info-detail">
                                    <span class="model-detail-label">{{$artistExtra2[$i]['title']}}</span>
                                    <span class="model-detail-value">{{$artistExtra2[$i]['value']}}</span>
                                </div>
                            @endfor
                        </div>

                    </div>
                @endif


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
    </div>
@endsection
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
            $('.loader-container').toggleClass("active");
            $('.grid-masonry').toggleClass("active");
            scrollParallaxPortraitImage();

            $(window).scroll (
                function() {scrollParallaxPortraitImage();
            });

            var $grid = $('.grid-masonry').masonry({
                columnWidth: '.grid-column-size',
                itemSelector: '.masonry-brick',
                percentPosition: true
            });
            $grid.imagesLoaded(function () {
                $grid.masonry('layout');
            })

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


            $(".fancybox").attr('rel', 'gallery')
                    .fancybox({
                        arrows : false,
                        closeBtn : false,
                        scrolling : 'no',
                        nextEffect : 'fade',
                        prevEffect : 'fade',
                        beforeShow: function() {
                            var $this = $(this.wrap);
                            if($this){
                                if($this.siblings('.fancybox-model-controller').length > 0) return;
                                var temp = '<a class="fancybox-model-controller fancybox-model-close" ><span class="gobyArtIcon">D</span></a>' +
                                    '<div class="fancybox-model-wrapper ">' +
                                    '<a class="fancybox-model-controller fancybox-model-previous"> ' +
                                    '<span class="gobyArtIcon">J</span></a> ' +
                                    '<a class="fancybox-model-controller fancybox-model-next">' +
                                    '<span class="gobyArtIcon">K</span></a>' +
                                    '</div>';
                                $(temp).prependTo($this.parent());
                                $this.parent().on('click', '.fancybox-model-previous', function(){
                                    $.fancybox.prev()
                                });
                                $this.parent().on('click', '.fancybox-model-next', function(){
                                    $.fancybox.next()
                                });
                                $this.parent().on('click', '.fancybox-model-close', function(){
                                    $.fancybox.close()
                                })
                            }
                        },
                        beforeClose: function () {
                            var $this = $(this.wrap);
                            console.log('ok');
                            if($this){
                                $('.fancybox-model-wrapper', $this.parent()).remove();
                                $('.fancybox-model-controller', $this.parent()).remove();
                            }
                        }
                    });
        })


    </script>
@endsection