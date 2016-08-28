@extends("layout.master")
@section("meta")
    @if(isset($siteOptions))
        <meta name="keywords" content="{{!isset($siteOptions['SITE_KEYWORD']) ? '' :$siteOptions['SITE_KEYWORD']}}">
        <meta name="description" content="{{!isset($siteOptions['SITE_DESCRIPTION']) ? '' : $siteOptions['SITE_DESCRIPTION']}}">
        <meta name="copyright" content="{{!isset($siteOptions['SITE_COPYRIGHT']) ? '' : $siteOptions['SITE_COPYRIGHT']}}">
        <meta name="author" content="{{!isset($siteOptions['SITE_AUTHOR']) ? '' : $siteOptions['SITE_AUTHOR']}}">
        <meta name="robots" content="all">
    @endif
@endsection
@section("content")

    <div id="title-video">
    </div>
    <div class="artist-type-wrapper">
        <div class="artist-type-content clear-fix">
            <div class="artist-type-content-inner">
                <div class="artist-type-search-content">
                    <div class="artist-text">
                        <p>Bạn đang quan tâm nghệ sĩ nào?</p>
                    </div>

                    <div class="form-search">
                        @if(isset($artistTypes))
                            @foreach($artistTypes as $artistType)
                                <div class="search-item">
                                    <input type="checkbox" id="icheck_{{ $artistType['type_slug']}}" name="iCheck" value="{{ $artistType['type_slug']}}">
                                    <label for="icheck_{{ $artistType['type_slug']}}" class="">{{ $artistType['type_name']}}</label>
                                </div>
                            @endforeach
                        @endif

                        {{--<div class="search-item">--}}
                            {{--<input type="checkbox" name="iCheck">--}}
                            {{--<label class="">Ca Sĩ</label>--}}
                        {{--</div>--}}
                        {{--<div class="search-item">--}}
                            {{--<input type="checkbox" name="iCheck">--}}
                            {{--<label class="">Ban Nhạc</label>--}}
                        {{--</div>--}}
                        {{--<div class="search-item">--}}
                            {{--<input type="checkbox" name="iCheck">--}}
                            {{--<label class="">PG PB | Người Mẫu</label>--}}
                        {{--</div>--}}
                        {{--<div class="search-item">--}}
                            {{--<input type="checkbox" name="iCheck">--}}
                            {{--<label class="">Nhóm Nhảy</label>--}}
                        {{--</div>--}}
                        {{--<div class="search-item">--}}
                            {{--<input type="checkbox" name="iCheck">--}}
                            {{--<label class="">Nghệ Sĩ Khác</label>--}}
                        {{--</div>--}}
                        <div class="search-item">
                            <a type="button" id="filter_btn"  class="btn btn-inverted btn-round text-uppercase">Khám Phá Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("pages.includes.hot-artist")
    {{--<a target="_blank">--}}
        {{--<div class="parallax parallax-spacer" id="home-spacer-image" style="background-image: url({{asset('assets/images/ICE_9427.jpg')}}); background-position: 50% -210.938px;">--}}
        {{--</div>--}}
    {{--</a>--}}
    @include("pages.includes.slogan")
    @include("pages.includes.partner")
@endsection
@section("scripts")
    <script type="text/javascript">
        $(function () {
            HomePage.initPage('{{isset($siteOptions) &&  isset($siteOptions['SITE_YOUTUBE_HOME_ID']) ? $siteOptions['SITE_YOUTUBE_HOME_ID'] : ''}}')
        });
    </script>
@endsection