<!DOCTYPE html>
<html lang="en" class="is-not-touch">
<head>
    <title>GobyArt</title>
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale = 1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="copyright" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <meta name="robots" content="all">
    {{--<link rel="icon" type="image/x-icon" href="_images/favicon.ico">--}}
    {{--<link rel="shortcut icon" type="image/x-icon" href="_common/images_sys/favicon.ico">--}}

    <link href="/assets/css/all.css" rel="stylesheet">
    @yield('styles')

     <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '293125094392412');
        fbq('track', "PageView");</script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=293125094392412&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
</head>

<body class="page">
    <header id="header" class="fixed">
        <div class="header clear-fix">
            <div class="header-bg"></div>
            <div class="logo gobyArtIcon">
                <a href="/" class="un-decoration">
                    <span class="logo-img"></span>
                    <span class="logo-dot">x</span>
                </a>
            </div>
            <div class="m_hidden l_hidden show-if-mobile-menu">
	  			<span class="gobyArtIcon">
	  				<a href="#" class="navigation-toggle">=</a>
	  			</span>
            </div>
            <div class="navigation s_hidden hide-if-mobile-menu">
                <ul>
                    <!-- 					<li class="selected">Models</li> -->
                    <li><a href="/nghe-si">Nghệ Sĩ</a></li>
                    {{--<li><a href="/tin-tuc">Tin Tức</a></li>--}}
                    <li><a href="/gioi-thieu">Giới Thiệu</a></li>
                    <li><a href="/lien-he">Liên Hệ</a></li>
                    <li>
                        <a href="/quan-tam">
                            <i class="material-icons">&#xE87E;</i>
                        </a>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div id="dummyheader"> <!-- spacer to  -->
        <div class="header clearfix" style="width:100%;">
            <div class="header-bg"></div>
            <div class="logo gobyArtIcon">
                <a href="/" class="un-decoration">
                    <span class="logo-img"></span>
                    <span class="logo-dot">x</span>
                </a>
            </div>
        </div>
    </div>



@yield('content')
    <div class="shadow"></div>
    <div class="footer parallax full-width" style="background-position: 50% 200px;">
        <div class="footer-inner">
            <div class="content col_padding_bottom">
                <!-- Head -->
                <div class="headbox">
                    <span class="footer-logo left gobyArtIcon">™</span>
                    <div class="socialbookmark-container">
                        <div class="socialbookmark-row">
                            <a href="https://www.facebook.com/ICE-Models-Germany-872495876166889/" target="_blank" class="social-bookmark"><span class="gobyArtIcon">O</span></a>
                            <a href="https://www.instagram.com/ice_models_germany" target="_blank" class="social-bookmark"><span class="gobyArtIcon">N</span></a>
                        </div>
                        <div class="socialbookmark-row">
                            <a href="https://vimeo.com/icegermany" target="_blank" class="social-bookmark"><span class="gobyArtIcon">Q</span></a>
                            <a href="https://icegermany.wordpress.com" target="_blank" class="social-bookmark"><span class="gobyArtIcon">V</span></a>
                        </div>
                    </div>
                </div>
                <!-- End Head -->
                <hr class="white-bd white-fg">
                <!-- 3 Col -->
                <div class="col col3_1 text_left">
                    <p>After 20 successful years in South Africa ICE Models and agency director Steffi Freier decided to open the first foreign subsidiary. Adapted from Cape Town, Johannesburg and Durban, Ice Germany was established in June 2015 with a team of experienced bookers.<br>
                        Besides the mediation of international models the focus lies on discovering and developing own models.</p>
                </div>

                <hr class="white l_hidden ">

                <div class="col col3_2 text_left">
                    <p><b>ICE models germany gbr</b><br>Hopfensack 19<br>D-20457 Hamburg<br><br><a href="mailto:info@icemodels.de">info@icemodels.de</a></p>
                </div>


                <div class="col col3_3 text_left">
                    <br class="l_hidden">
                    <p>Phone<br><u>+84 989139263</u></p>
                    <hr class="white l_hidden">
                    <p style="opacity: 0.9">
                        <br class="s_hidden m_hidden">
                        © 2016 GOBY ART
                    </p>

                </div>
                <!-- End 3 Col -->
            </div>
        </div>
    </div>

<script src="/assets/js/all.js"></script>
<script src="/assets/js/common.js"></script>

@yield('scripts')

</body>
</html>