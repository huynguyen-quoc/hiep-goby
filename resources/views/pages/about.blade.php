@extends("layout.master")
@section("content")

    @include("pages.includes.about-content")

    @include("pages.includes.team")

    @include("pages.includes.about-event")
@endsection
@section("scripts")
    <script type="text/javascript">


        $(function () {
            AboutPage.initPage();

        })


    </script>
@endsection