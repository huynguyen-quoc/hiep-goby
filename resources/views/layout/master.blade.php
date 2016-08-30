<!DOCTYPE html>
<html lang="en" class="is-not-touch">
    <head>
        <title>GoBy Art</title>
        <meta charset="utf-8">

        @yield('meta')

        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale = 1, maximum-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{--<link rel="icon" type="image/x-icon" href="_images/favicon.ico">--}}
        {{--<link rel="shortcut icon" type="image/x-icon" href="_common/images_sys/favicon.ico">--}}

        <link href="/assets/vendor/iCheck/skins/all.css" rel="stylesheet">
        <link href="/assets/vendor/kendo/kendo.common.css" rel="stylesheet">
        <link href="/assets/vendor/kendo/kendo.default.css" rel="stylesheet">
        <link href="/assets/vendor/kendo/kendo.silver.css" rel="stylesheet">
        <link href="/assets/vendor/fancybox/jquery.fancybox.css" rel="stylesheet">

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

        @include('includes.header')


        @yield('content')

        </div>
        <div class="shadow"></div>
        @include('includes.footer')
        @include('includes.image-popover')

        <script  type="text/javascript" src="/assets/js/all.js?v=1.0.1"></script>
        <script  type="text/javascript" src="/assets/vendor/iCheck/icheck.js"></script>
        <script  type="text/javascript" src="/assets/vendor/fancybox/jquery.fancybox.pack.js"></script>
        <script  type="text/javascript"  src="/assets/js/common.js?v=1.0.1"></script>

        @yield('scripts')

    </body>
</html>