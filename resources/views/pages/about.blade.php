@extends("layout.master")
@section("content")

    <a target="_blank">
        <div class="parallax parallax-spacer" id="about-spacer-image" style="min-height:400px;background-image: url({{asset('assets/images/ICE_9427.jpg')}}); background-position: 50% -210.938px;">
        </div>
    </a>
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
        };
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

        $(function () {
            $('body').toggleClass('about');
            $('.loader-container').toggleClass("active");
            scrollParallaxAboutImage();$(window).scroll (function() {scrollParallaxAboutImage();});


            $grid2.imagesLoaded().progress( function() {
                $grid.masonry('layout');
            });


        })


    </script>
@stop()