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
    $(function(){
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

    });


})(window.jQuery);