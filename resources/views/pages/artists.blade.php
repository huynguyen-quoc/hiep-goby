@extends("layout.master")
@section("content")
    <div class="full-width bg-grey">
        <div class="content">
            <div class="artist-filter">
                <ul>
                    <li  class="">
                        <a href="#">All</a>
                    </li>
                    @foreach ($artistFilter as $item)
                        <li class="">
                            <a href="#">{{$item}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="artist-filter-type">
                sort by <span>alphabet</span>
            </div>
        </div>
    </div>
    @include("pages.includes.artists")
@stop()
@section("scripts")
    <script type="text/javascript">

        //POP OVER
        var showPopover=function(event){
            window.clearTimeout(window.showPopoverTimeout);

            var targetEl=$(event.currentTarget);
            if(targetEl==undefined) return false;
            var targetElPosition=targetEl.offset();

            var top=targetElPosition.top;
            var left=targetElPosition.left;
            var height=targetEl.outerHeight();
            var width=targetEl.outerWidth();
            var padding=targetEl.parent().innerHeight()-height;

            var popupMainCss={
                top: top - padding,
                left: left - padding,
            };
            var popupInfoCss={
                top: 0,
                left: 0,
                width: width + 2 * padding,
                padding: padding
            };
            var modelInfoCss={
                marginTop: height + padding
            };
            var popupGridCss={
                top: 0,
                left: 'auto',
                right: 'auto',
                width:  popupInfoCss.width * 1.05,
                paddingTop: padding,
                paddingRight: 0,
                paddingBottom: 0,
                paddingLeft: 0,
                display: 'block'
            };
            var popupGridColumnCss={
                paddingRight: 0,
                paddingLeft: 0,
                marginBottom: padding
            };

            var offsetParent=$('body');
            var offsetParentWidth=offsetParent.innerWidth();

            var shadowCss={};
            if(left < (offsetParent.offset().left+offsetParentWidth/2)){
                // position on right
                popupGridCss.left=popupInfoCss.width;
                popupGridColumnCss.paddingRight=padding;
                $('#model-image-popover').removeClass("model-on-right").addClass("model-on-left").css(shadowCss);
            }
            else{
                // position on left
                popupGridCss.left=-popupGridCss.width;
                popupGridColumnCss.paddingLeft=padding;
                $('#model-image-popover').removeClass("model-on-left").addClass("model-on-right").css(shadowCss);

            }

            // apply css
            $('#model-image-popover').css(popupMainCss);
            $('#model-image-popover-info').css(popupInfoCss);
            $('#model-image-popover-info #model-info').css(modelInfoCss);
            $('#model-image-popover-grid').css(popupGridCss);
            $('#model-image-popover-grid .grid-model-image-popover-column').css(popupGridColumnCss);

            // change layer ordering
            targetEl.closest('.grid-masonry').find(".model").css({'z-index':0});
            targetEl.css({'z-index':29});

            window.showPopoverTimeout=window.setTimeout(function(){$('#model-image-popover').hide().fadeIn(100);}, 250);
        };

        var hidePopover = function(event){
            window.clearTimeout(window.showPopoverTimeout);
            $('#model-image-popover').fadeOut(100);
        };

        $(function () {
            $('body').toggleClass('artists');
            $('.loader-container').toggleClass("active");
            $('.grid-masonry').toggleClass("active");

            $('.grid-masonry').masonry({
                columnWidth: '.grid-column-size',
                itemSelector: '.masonry-brick',
                percentPosition: true
            });

            $(".grid-item").hoverIntent({
                over: showPopover,
                out: hidePopover
            });


        })


    </script>
@stop()