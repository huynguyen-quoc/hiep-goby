/**
 * Created by huynguyen on 8/20/16.
 */
var parallaxScrollEnabled=true;
if( $(window).width() < 800 || navigator.userAgent.match(/(iPod|iPhone|iPad)/) ){
    parallaxScrollEnabled=false;
}
(function($){


    if (window.parallaxScrollEnabled==false) {
        $(".parallax").addClass("background-attachment-scroll");
    }

    $(document).on('touchstart', function(event) {
        if(event.type=='touchstart'){
            $('html').removeClass('is-not-touch');
            $('html').addClass('is-touch');
            $(document).off('touchstart');
        }
    });

    var addToCart = function(e){
        e.preventDefault();
        var $this = $(this);
        $this.toggleClass('loading');
        $this.off('click');
        var artist = $this.closest('article').data('artist');
        var words = CryptoJS.enc.Base64.parse(artist);
        var textString = CryptoJS.enc.Utf8.stringify(words);
        $.ajax({
            url : '/api/cart',
            type:"POST",
            contentType:"application/json; charset=utf-8",
            dataType:"json",
            data: textString,
            success: function(data){
                $this.toggleClass('loading');
                var cart = $('.shopping-cart');
                var dragItem = $this.find(".button-loading");
                $this.on('click', removeFromCard);
                $this.closest('.model').toggleClass('wishlist');
                if (dragItem) {
                    var width = $this.width();
                    var height =$this.height();
                    var dragItemClone = dragItem.clone()
                        .offset({
                            top: dragItem.parent().offset().top + height / 2,
                            left: dragItem.parent().offset().left + width / 2
                        })
                        .css({
                            'position': 'absolute',
                            'display': 'block',
                            'z-index' : 9999
                        })
                        .appendTo($('body'))
                        .animate({
                            'top': cart.offset().top + 10,
                            'left': cart.offset().left + 10,
                        }, 1000);

                    dragItemClone.animate({
                        'width': 0,
                        'height': 0
                    }, function () {
                        var count = data['total_cart'];
                        $('.wishlist-counter').text(count);
                        $(this).detach()
                    });
                }
            },error : function(){
                $this.toggleClass('loading');
                $this.on('click', addToCart);
            }
        });
    };
    var removeFromCard = function(e){
        e.preventDefault();
        var $this = $(this);
        $this.toggleClass('loading');
        $this.off('click');
        var artist = $this.closest('article').data('artist');
        var words = CryptoJS.enc.Base64.parse(artist);
        var textString = CryptoJS.enc.Utf8.stringify(words);
        $.ajax({
            url : '/api/cart/' + JSON.parse(textString).artist_slug,
            type:"DELETE",
            contentType:"application/json; charset=utf-8",
            dataType:"json",
            success: function(data){
                $this.toggleClass('loading');
                var count = data['total_cart'];
                $('.wishlist-counter').text(count);
                $this.on('click', addToCart);
                $this.closest('.model').toggleClass('wishlist');
            },error : function(){
                $this.toggleClass('loading');
                $this.on('click', removeFromCard);
            }
        });
    };

    var deactiveItemsInParentTouchItemScope = function(el){
        if($('html').hasClass('is-touch')){
            $(el).closest('.touch-item-wrapper').find('.active-touch').removeClass('active-touch');
        }
    };


    $(function(){
            $(".navi_mobile").slideToggle(200);
            $(".navi_mobile").on('touchmove', function(e) {
                e.preventDefault();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // HEAD ROOM
            var header = document.querySelector("#header");
            if(header!= undefined){
                new Headroom(header, {
                    tolerance: {
                        down : 2,
                        up : 5
                    },
                    offset : 450,
                    classes: {
                        initial: "slide--top",
                        pinned: "slide--reset",
                        unpinned: "slide--up",
                        top : "slide--top",
                        notTop : "slide--not-top"
                    },
                    onUnpin:function(){
                        if(this.lastKnownScrollY<=this.offset*3){
                            $(this.elem).addClass('slide--up-from-top');
                        }
                    },
                    onPin:function(){
                        $(this.elem).removeClass('slide--up-from-top');
                    }
                }).init();
            }
            $('.model:not(.wishlist) .wishlist-toggle-wrapper').on('click', addToCart);
            $('.model.wishlist .wishlist-toggle-wrapper').on('click', removeFromCard);
            $('.model a').on('click touchstart', function(event){
                var $html = $('html');
                var $this = $(this);
                if($html.hasClass('is-touch')){
                    //if(event.type=='click'){
                        var item= $this.closest('.touch-item');
                        if(item.length){
                            if(item.hasClass('active-touch')){
                                return true;
                            }
                            else{
                                event.stopPropagation();
                                event.preventDefault();
                                event.stopNextHandler=true;
                                deactiveItemsInParentTouchItemScope(item);
                                item.addClass('active-touch');
                                return false;
                            }
                        }
                    //}
                }
            })

    });


})(window.jQuery);
/**
 * Created by huynguyen on 8/20/16.
 */

var ArtistPage = function(){

    var initPage = function(totalGrid){
        $('body').toggleClass('artists');
        $('.loader-container').toggleClass("active");
        $('.grid-masonry').toggleClass("active");

        initGrid(totalGrid);
        initAddCart();
    };

    var initGrid = function(totalGrid){

        var $grid = $('.grid-masonry').masonry({
            columnWidth: '.grid-column-size',
            itemSelector: '.masonry-brick',
            percentPosition: true
        });

        var infiniteScroll = $('.grid-masonry').infinitescroll({
                navSelector  : "#pagination",
                // selector for the paged navigation (it will be hidden)
                nextSelector : "#pagination p a",
                // selector for the NEXT link (to page 2)
                itemSelector : ".grid-masonry .masonry-brick",
                dataType : 'json',
                loading: {
                    finished:  function(opts){
                        $('#loading-more-btn').html(' <span class="gobyArtIcon medium">F</span><br>Load More</a>');
                    },
                    finishedMsg: '',
                    img: undefined,
                    msg: undefined,
                    msgText :'',
                    selector: null,
                    speed: 'fast',
                    start:  function(opts){
                        if(totalGrid <= opts.state.currPage) return;
                        $('#loading-more-btn').html(' <span class="gobyArtIcon medium">F</span><br>Loading...</a>');
                        var  path = opts.path;
                        opts.state.currPage++;
                        var  desturl = (typeof path === 'function') ? path(opts.state.currPage - 1) : path.join(opts.state.currPage - 1);

                        $.ajax({
                            dataType: 'json',
                            type: 'GET',
                            url: desturl,
                            success: function (data, textStatus, jqXHR) {
                                opts.loading.finished.call($(opts.contentSelector)[0],opts);
                                opts.state.isDuringAjax = false;
                                if(data.total_page >= opts.state.currPage) {
                                    opts.state.isDone = true;
                                    $('#loading-more-btn').remove();
                                }
                                opts.callback($(opts.contentSelector)[0],data,desturl);
                            },
                            error: function() {
                            }
                        });
                    }
                },
                appendCallback: false,
                path : function(currentPageNumber){
                    return (window.location.href+'?page=' + currentPageNumber);
                }
            },
            // Function called once the elements are retrieved
            function(data) {
                var artists =  data.artists;
                var temps = [];
                $.each(artists, function(index, artist){
                    var url = '/assets/upload/' + artist.artist_type_slug + '/' + artist.artist_slug + '/' + artist.artist_avatar;
                    var data = JSON.stringify(artist);
                    var wordArray = CryptoJS.enc.Utf8.parse(data);
                    var base64 = CryptoJS.enc.Base64.stringify(wordArray);

                    var template = "<div class='masonry-brick'> <article class='model grid-item' data-artist='" + base64 + "'>" +
                        "<a href='/nghe-si' > " +
                        "<div class='model-img-wrapper model-background-img-wrapper' style='background-image: url(" + url + ")'>" +
                        "<div class='model-name-box'> <span class='model-name' data-name='" + artist.artist_name + "'></span> </div>" +
                        "<div class='wishlist-icon-wrapper in-wishlist' > <div class=''>" +
                        "<span class='model-is-active gobyArtIcon'>D</span> <span class='gobyArtIcon'>S</span> </div> </div>" +
                        "<div class='wishlist-toggle-wrapper'> <div class='in-wishlist'> " +
                        "<span class='icon-label s_hidden'>Shortlist remove</span> " +
                        "<span class='icon-label l_hidden m_hidden'>Shortlist </span> " +
                        "<span class='sofaIcon l_hidden m_hidden'>D</span> " +
                        "</div>" +
                        "<div class='not-in-wishlist'>" +
                        "<span class='icon-label s_hidden'>Add to shortlist</span>" +
                        " <span class='icon-label l_hidden m_hidden'>Shortlist +</span>" +
                        "</div>" +
                        "</div>" +
                        "</div> </a> " +
                        "<div class='model-name-wrapper'> <a href='#'> <span class='model-name'>" + artist.artist_name + "</span> </a>"+
                        "</div> </article> </div>";
                    // $grid.append($.parseHTML(template));
                    temps.push($.parseHTML(template)[0]);
                });
                temps = $(temps).css('opacity', 0);
                temps.animate({opacity: 1});
                $grid.append(temps);
                $grid.masonry('appended', temps);
            });

        $(".grid-masonry").on('mouseenter', '.grid-item',function(e){
            var $this = $(this);
            var artist = $this.data('artist');
            if(artist) {
                var words = CryptoJS.enc.Base64.parse(artist);
                var textString = CryptoJS.enc.Utf8.stringify(words);
                initImagePopover(e, JSON.parse(textString))
            }
        });
        $('.grid-masonry').hoverIntent({
            over: showPopover,
            out: hidePopover,
            selector: '.grid-item'
        });
    };

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

    var initImagePopover=function(event, model){
        var information_data_1 = model.artist_extra_1;
        var information_data_2 = model.artist_extra_2;
        $('#model-image-popover .model-info-model-name').html(model['artist_full_name']);
        $('#model-image-popover .model-type').html("(" + model['artist_type_name'] + ")");
        var information1Data = '';
        var information2Data = '';
        $('#model-image-popover .model-info-col-1').empty();
        $('#model-image-popover .model-info-col-2').empty();

        $.each(information_data_1 , function(){
            var template = '<div class="model-info-detail">' +
                '<span class="model-detail-label">' + this.title + '</span>' +
                '<span class="model-detail-value" >' + this.value + '</span>' +
                '</div>';
            information1Data += template;
        });
        $.each(information_data_2 , function(){
            var template = '<div class="model-info-detail">' +
                '<span class="model-detail-label">' + this.title + '</span>' +
                '<span class="model-detail-value" >' + this.value + '</span>' +
                '</div>';
            information2Data += template;
        });
        $('#model-image-popover .model-info-col-1').html(information1Data);
        $('#model-image-popover .model-info-col-2').html(information2Data);

        $.ajax({
            url : '/api/image/preview/' + model.artist_slug,
            type:"GET",
            contentType:"application/json; charset=utf-8",
            dataType:"json",
            success: function(data){
                $('#model-image-popover-grid .grid-model-image-popover .grid-model-image-popover-column').empty();
                if(data.length > 0){
                    var template  =  '<div class="grid-item"> <img src="/assets/upload/' + data[0].artist_type + '/' + data[0].artist_name + '/' + data[0].file_name + '"></div>';
                    if(data.length > 1) {
                        template += '<div class="grid-item"> <img src="/assets/upload/' +  data[1].artist_type+ '/' + data[1].artist_name + '/' +  data[1].file_name + '"></div>';
                    }
                    $('#model-image-popover-grid .grid-model-image-popover .grid-model-image-popover-column.column-1').html(template);
                    template  = '';
                    if(data.length > 2) {
                        template +=' <div class="grid-item"> <img src="/assets/upload/' + data[2].artist_type + '/' + data[2].artist_name + '/' + data[2].file_name + '"></div>';
                        if(data.length > 3) {
                            template += '<div class="grid-item"> <img src="/assets/upload/' +  data[3].artist_type+ '/' + data[3].artist_name + '/' +  data[3].file_name + '"></div>';
                        }
                    }
                    $('#model-image-popover-grid .grid-model-image-popover .grid-model-image-popover-column.column-2').html(template);
                }
            }
        });

        //   var requestId = model['artist_slug'] + "_" + Math.random();
//            if(requestId!=$scope.imagePopover.requestId){
//                $scope.imagePopover.images=$scope.defaultImagePopoverImageArray;
//            }
//            $scope.imagePopover.requestId=requestId;
//            $scope.imagePopover.isActive=true;
//            $scope.imagePopover.model=model;
//
//            ImageSet.server().get({imageTypeString:'preview',modelString:model.name},function(data){
//                if(data.$resolved && (!data.data!=undefined) && (requestId==$scope.imagePopover.requestId)){
//                    $scope.imagePopover.images=ImageSet.getImagesFromImageSet(data);
//                }
//            });
    };


    var initAddCart = function(){

    };


    return {
        initPage : initPage
    }
}();
/**
 * Created by huynguyen on 8/26/16.
 */


var HomePage = function(){

    var initPage = function(youtube){
        $('body').toggleClass('home');
        $('.loader-container').toggleClass("active");
        $('.grid-masonry').toggleClass("active");
        $('.partner-slideshow-wrapper').toggleClass('hidden-data');
        scrollParallaxHomeImage();$(window).scroll (function() {scrollParallaxHomeImage();});
        $('#title-video').html('<iframe  src="https://www.youtube.com/embed/' + youtube+ '?autoplay=1&controls=0&modestbranding=1&loop=1&playlist=' + youtube
            +'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>').fitVids();
        initSlider();
        initGrid();
        initCheckBox();
    };

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
    };

    var initCheckBox = function(){
        $('input[name=iCheck]').iCheck({
            checkboxClass: 'iradio_square-pink artist-check',
            radioClass: 'iradio_flat-pink',
            uncheckedClass: 'test',
            increaseArea: '20%' // optional
        });
        $("#filter_btn").on('click' , function(e){
            e.preventDefault();
            e.stopPropagation();
            var data = $.map($('input[name="iCheck"]:checked'), function(item, index){
                return $(item).val();
            });
            if(data.length <= 0) return;
            window.location.href='/danh-sach-nghe-si/' + data.join('_');
        });
    };

    var initGrid = function(){
        $('.grid-masonry').masonry({
            columnWidth: '.grid-column-size',
            itemSelector: '.masonry-brick',
            percentPosition: true
        });

    };

    var initSlider = function(){
        $("#partner-slideshow").slick({
            slidesToScroll: 5,
            variableWidth: true,
            autoPlay: true,
            infinite: true,
            arrows: true,
            dots : false,
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
    }





    return {
        initPage : initPage
    }
}();
//# sourceMappingURL=common.js.map
