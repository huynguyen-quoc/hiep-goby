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
                        initial: "slide",
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

    });


})(window.jQuery);