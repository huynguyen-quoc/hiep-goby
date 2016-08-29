@extends("layout.master")
@section("content")
        <div class="full-width bg-grey">
            <div class="content  ">
                <div class="headbox evenpadding">
                    <div class="wishlist-controls clear-fix">
                        <ul>
                            @foreach($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                        {!! Form::open(array('action' => 'WishListController@create')) !!}
                        <div class="col col1 text-left">
                            {!! Form::text('customer_name', null,
                                array('required',
                                      'class'=>'',
                                      'placeholder'=>'Tên Khách Hàng')) !!}
                            {!! Form::text('event_name', null,
                               array('required',
                                     'class'=>'',
                                     'placeholder'=>'Tên Sự Kiên')) !!}
                            {!! Form::text('email_address', null,
                               array('required',
                                     'class'=>'',
                                     'placeholder'=>'Địa chỉ Email')) !!}
                            {!! Form::text('phone_number', null,
                              array('required',
                                    'class'=>'',
                                    'placeholder'=>'Số điện thoại')) !!}
                            {!! Form::text('event_time', null,
                               array('required',
                                     'class'=>'',
                                     'placeholder'=>'Thời Gian Tổ Chức')) !!}
                            {!! Form::text('event_location', null,
                               array('required',
                                     'class'=>'',
                                     'placeholder'=>'Địa Điểm Tổ Chức')) !!}
                        </div>
                        <div class="col col2 text-left">
                            {!! Form::textarea('extra_information', null,
                               array('',
                                     'class'=>'form-control',
                                     'placeholder'=>'Thông Tin Thêm')) !!}
                            {!! Form::submit('Gửi',
                                     array('class'=>'btn btn-inverted btn-round text-uppercase')) !!}
                        </div>
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
        @include("pages.includes.artist-wishlist")
@endsection
@section("scripts")
            <script type="text/javascript">

                $(function () {
                    WishListPage.initPage()

                })


            </script>
@endsection