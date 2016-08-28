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
    <div class="full-width bg-grey">
        <div class="content">
            <div class="artist-filter">
                <ul>
                    <li class="{{ Request::segment(3) == '' || Request::segment(3) == 'tat-ca' ? 'selected' : '' }}" data-value="tat-ca">
                        <a href="{{ (Request::segment(3) != '') ? preg_replace('~/([^/]*)$~',  '/tat-ca', Request::url()) : Request::url().'/tat-ca'}}">Tất Cả</a>
                    </li>
                    @foreach ($artistFilter as $item)
                        <li class="{{ Request::segment(3) == $item ? 'selected' : '' }}" data-value="{{$item}}">
                            <a href="{{ (Request::segment(3) != '') ? preg_replace('~/([^/]*)$~',  '/'.strtolower($item), Request::url()) : Request::url().'/'. strtolower($item)}}">{{$item}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="artist-filter-type">
                {{--sort by <span>alphabet</span>--}}
            </div>
        </div>
    </div>
    @include("pages.includes.artists")
@endsection
@section("scripts")
    <script type="text/javascript">

        $(function () {
           ArtistPage.initPage({{$totalPage}});
        })

    </script>
@endsection