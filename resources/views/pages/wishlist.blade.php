@extends("layout.master")
@section("content")
        <div class="full-width bg-grey">
            <div class="content  ">
                <div class="headbox evenpadding">
                    <div class="wishlist-controls clear-fix">
                        <div class="col col1 text-left">
                            <input type="text" name="customer_name" placeholder="Tên Khách Hàng" >
                            <input type="text" name="event_name" placeholder="Tên Sự Kiên" >
                            <input type="text" name="email" placeholder="Địa chỉ Email">
                            <input type="text" name="event_date" placeholder="Thời Gian Tổ Chức">
                            <input type="text" name="event_location" placeholder="Địa Điểm Tổ Chức">
                        </div>
                        <div class="col col2 text-left">
                            <textarea name="notice" placeholder="Thông Tin Thêm"></textarea>
                            <a href="" class="btn btn-inverted btn-round text-uppercase">Gửi</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @include("pages.includes.artist-wishlist")
@stop()
        @section("scripts")
            <script type="text/javascript">

                $(function () {
                    $('body').toggleClass('wishlist');

                    $('.grid-masonry').masonry({
                        columnWidth: '.grid-column-size',
                        itemSelector: '.masonry-brick',
                        percentPosition: true
                    });

                })


            </script>
@stop()