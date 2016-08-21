<div class="full-width bg-grey with-bottom-padding ">
    <div class="content video-content">
        <div class="headbox">
            <span class="text_left text-uppercase">Video</span>
        </div>
        <hr>
        <div class="video-slider-wrapper">
            <div id="video-slider">
                <div class="item-video-slider grid-item">
                    <div class="model-video-wrapper video_16_9">
                        <div class="video-inner">
                            <a  class="video-slider-image-wrapper" data-src="//www.youtube.com/embed/f4Py54JZC8M"
                                style="background-image: url({{asset('assets/images/video/1.jpg')}});" tabindex="0">
                                <div class="video-image-overlay"></div>
                                <div class="video-image-play-icon">
                                    <span class="gobyArtIcon active">c</span>
                                    <span class="gobyArtIcon">a</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item-video-slider grid-item">
                    <div class="model-video-wrapper video_16_9">
                        <div class="video-inner">
                            <a  class="video-slider-image-wrapper" data-src="//player.vimeo.com/video/171718759?color=c9ff23&title=0&byline=0&portrait=0"
                                style="background-image: url({{asset('assets/images/video/2.jpg')}});" tabindex="0">
                                <div class="video-image-overlay"></div>
                                <div class="video-image-play-icon">
                                    <span class="gobyArtIcon active">c</span>
                                    <span class="gobyArtIcon">a</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="video-bt-left-wrapper">
                <a class="video-bt-left gobyArtIcon" onclick="$('#video-slider').slick('slickPrev');">J</a>
            </div>
            <div class="video-bt-right-wrapper">
                <a class="video-bt-right gobyArtIcon" onclick="$('#video-slider').slick('slickPrev');">K</a>
            </div>
        </div>
    </div>
</div>
