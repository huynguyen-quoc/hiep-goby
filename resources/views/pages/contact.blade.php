@extends("layout.master")
@section("content")
        <div id="map-canvas">
        </div>
        <div class="full-width bg-grey">
            <div class="content">
                <div class="headbox evenpadding">
                    <div class="contact-controls clear-fix">
                        <div class="col col1 text-left">
                            <input type="text" name="customer_name" placeholder="Họ Và Tên" >
                            <input type="text" name="event_name" placeholder="Số điện thoại" >
                            <input type="text" name="email" placeholder="Địa chỉ Email">
                            <div class="text-right">
                                <a href="" class="btn btn-inverted btn-round text-uppercase">Gửi</a>
                            </div>
                        </div>
                        <div class="col col2 text-left">
                            <input type="text" name="title" placeholder="Tiêu Đề">
                            <textarea name="content" placeholder="Nội Dung"></textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
@section("scripts")
            <script type="text/javascript">
                var map;
                function initMap(){
                    var locations = [
                        ['{{ $siteOptions['SITE_NAME'] }}', '{{ $siteOptions['SITE_DESCRIPTION'] }}', '{{ $siteOptions['SITE_PHONE'] }}',
                           '{{ $siteOptions['SITE_EMAIL_ADDRESS'] }}', '{{ $siteOptions['SITE_URL'] }}', '{{ $siteOptions['SITE_LOCATION_LONGITUDE'] }}','{{ $siteOptions['SITE_LOCATION_LATTUDE'] }}',
                            'https://mapbuildr.com/assets/img/markers/default.png']
                    ];

                    var mapOptions = {
                        center: new google.maps.LatLng({{ $siteOptions['SITE_LOCATION_LONGITUDE'] }}, {{  $siteOptions['SITE_LOCATION_LATTUDE']  }}),
                        zoom: 16,
                        zoomControl: true,
                        zoomControlOptions: {
                            style: google.maps.ZoomControlStyle.SMALL,
                        },
                        disableDoubleClickZoom: true,
                        mapTypeControl: false,
                        scaleControl: false,
                        scrollwheel: false,
                        panControl: false,
                        streetViewControl: false,
                        draggable: true,
                        overviewMapControl: false,
                        overviewMapControlOptions: {
                            opened: false,
                        }
                    }
                    map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                    for (i = 0; i < locations.length; i++) {
                        if (locations[i][1] =='undefined'){ description ='';} else { description = locations[i][1];}
                        if (locations[i][2] =='undefined'){ telephone ='';} else { telephone = locations[i][2];}
                        if (locations[i][3] =='undefined'){ email ='';} else { email = locations[i][3];}
                        if (locations[i][4] =='undefined'){ web ='';} else { web = locations[i][4];}
                        if (locations[i][7] =='undefined'){ markericon ='';} else { markericon = locations[i][7];}
                        marker = new google.maps.Marker({
                            icon: markericon,
                            position: new google.maps.LatLng(locations[i][5], locations[i][6]),
                            map: map,
                            title: locations[i][0],
                            desc: description,
                            tel: telephone,
                            email: email,
                            web: web
                        });
                        if (web.substring(0, 7) != "http://") {
                            link = "http://" + web;
                        } else {
                            link = web;
                        }
                        ContactPage.bindInfoWindow(marker, map, locations[i][0], description, telephone, email, web, link);
                    }
                }

                $(function () {
                    ContactPage.initPage();
                })

            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMWvrZkeLRrGTqh9RgY7niHemli1HIPDU&callback=initMap"
                    type="text/javascript"></script>

@endsection