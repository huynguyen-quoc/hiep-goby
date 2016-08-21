@extends("layout.master")
@section("content")

    <div id="title-video">
    </div>
    @include("pages.includes.hot-artist")
    <a target="_blank">
        <div class="parallax parallax-spacer" id="home-spacer-image" style="background-image: url({{asset('assets/images/ICE_9427.jpg')}}); background-position: 50% -210.938px;">
        </div>
    </a>
    @include("pages.includes.slogan")
    @include("pages.includes.partner")
@stop()
@section("scripts")
    <script type="text/javascript">
        var scrollParallaxHomeImage = function(){
            var el=$('#home-spacer-image');
            var speed=0.75
            var bgPositionOffsetY = 0;
            var newPositionY=bgPositionOffsetY;
            if(el.length>0){
                if(window.parallaxScrollEnabled){
                    var windowHeight=$(window).height();
                    var top = el.offset().top;
                    var scrollY = $(window).scrollTop();
                    if( scrollY + windowHeight + 100 > top && top - windowHeight - 100 < scrollY){
                        distance = scrollY - top;
                        newPositionY=(bgPositionOffsetY - distance * speed)+"px";
                    }
                }
                elBackgrounPos = "50% " + newPositionY;
                el.css({backgroundPosition: elBackgrounPos});
            }
        }

        $('#title-video').html('<iframe  src="https://www.youtube.com/embed/Qp7_3DIxsbU?autoplay=1&controls=0&modestbranding=1&loop=1&playlist=Qp7_3DIxsbU" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>').fitVids();

        $(function () {
            $('body').toggleClass('home');
            $('.loader-container').toggleClass("active");
            $('.grid-masonry').toggleClass("active");
            //$('.partner-slideshow-wrapper').toggleClass('hidden-data');
            scrollParallaxHomeImage();$(window).scroll (function() {scrollParallaxHomeImage();});

            $('.grid-masonry').masonry({
                columnWidth: '.grid-column-size',
                itemSelector: '.masonry-brick',
                percentPosition: true
            });

            $("#partner-slideshow").slick({
                slidesToScroll: 5,
                variableWidth: true,
                autoplay: false,
                fade: false,
                dots: false,
                pauseOnHover: false,
                arrows: true,
                draggable: true,
                infinite:false,
                accessibility: false,
                responsive: [
                    {
                        breakpoint: 850,
                        settings:{
                            slidesToScroll: 3
                        }
                    }
                    ,{
                        breakpoint: 640,
                        settings:{
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        })


    </script>
@stop()