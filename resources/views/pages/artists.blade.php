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
                    <li  class="">
                        <a href="#">All</a>
                    </li>
                    @foreach ($artistFilter as $item)
                        <li class="">
                            <a href="#">{{$item}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="artist-filter-type">
                sort by <span>alphabet</span>
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