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
                function bindInfoWindow(marker, map, title, desc, telephone, email, web, link) {
                    var infoWindowVisible = (function () {
                        var currentlyVisible = false;
                        return function (visible) {
                            if (visible !== undefined) {
                                currentlyVisible = visible;
                            }
                            return currentlyVisible;
                        };
                    }());
                    iw = new google.maps.InfoWindow();
                    google.maps.event.addListener(marker, 'click', function() {
                        if (infoWindowVisible()) {
                            iw.close();
                            infoWindowVisible(false);
                        } else {
                            var html= "<div class='infoWindow'><h4>"+title+"</h4><p>"+desc+"<p><p>"+telephone+"<p><a href='mailto:"+email+"' >"+email+"<a><br/><a href='"+link+"'' >"+web+"<a></div>";
                            iw = new google.maps.InfoWindow({content:html});
                            iw.open(map,marker);
                            infoWindowVisible(true);
                        }
                    });
                    google.maps.event.addListener(iw, 'closeclick', function () {
                        infoWindowVisible(false);
                    });
                }

                var map;
                function initMap(){
                    var locations = [
                        ['Goby ART', 'Goby Art là trung tâm chuyên cung cấp nhân sự tổ chức sự kiện,' +
                        ' với một cơ sở dữ liệu khổng lồ gồm các nhân sự chuyên nghiệp trong các lĩnh vực' +
                        ' biểu diễn nghệ thuật: ca sỹ, nhóm nhảy, nhóm múa, MC, xiếc, ban nhạc, người mẫu ... ' +
                        'với phong cách tự tin chuyên nghiệp sẽlàm sự kiện của bạn nổi bật.', '+84 989139263',
                            'gobyart@gobyart.vn',
                            'www.gobyart.vn', {{ $longitude }},{{ $latitude }},
                            'https://mapbuildr.com/assets/img/markers/default.png']
                    ];

                    var mapOptions = {
                        center: new google.maps.LatLng({{ $longitude }}, {{ $latitude }}),
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
                        bindInfoWindow(marker, map, locations[i][0], description, telephone, email, web, link);
                    }
                }

                $(function () {
                    $('body').toggleClass('wishlist');

                    $('.grid-masonry').masonry({
                        columnWidth: '.grid-column-size',
                        itemSelector: '.masonry-brick',
                        percentPosition: true
                    });

                })

            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMWvrZkeLRrGTqh9RgY7niHemli1HIPDU&callback=initMap"
                    type="text/javascript"></script>

@endsection