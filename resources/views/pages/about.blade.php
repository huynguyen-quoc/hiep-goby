@extends("layout.master")
@section("content")

    @include("pages.includes.about-content")

    @include("pages.includes.team")

    @include("pages.includes.about-event")
@stop()
@section("scripts")
    <script type="text/javascript">

        var scrollParallaxAboutImage = function(){
            var el=$('#about-spacer-image');
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
        $(function () {
            $('body').toggleClass('about');
            $('.loader-container').toggleClass("active");
            $('.grid-masonry').toggleClass("active");
            scrollParallaxAboutImage();$(window).scroll (function() {scrollParallaxAboutImage();});
            var $grid = $('.team-masonry').masonry({
                columnWidth: '.grid-column-size',
                itemSelector: '.masonry-brick',
                percentPosition: true
            });

            var $grid2 = $('.event-masonry').masonry({
                columnWidth: '.grid-column-size',
                itemSelector: '.masonry-brick',
                percentPosition: true
            });

            $grid2.imagesLoaded(function () {
                $grid2.masonry('layout');
            })
        })


    </script>
@stop()