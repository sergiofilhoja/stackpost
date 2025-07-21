<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  dir="{{ Language::getCurrent('dir') }}" class="{{ UserInfo::getDataUser("sidebar-small", 1)?"sidebar-small":"" }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="{{ get_option("website_keyword", config('site.keywords')) }}">
    <meta name="description" content="{{ get_option("website_description", config('site.description')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ url( get_option("website_favicon", asset('public/img/favicon.png')) ) }}">
    <title>
        @hasSection('pagetitle')
            @yield('pagetitle')
        @else
            {{ (module("name") ?? '' ) . " | " . get_option("website_title", config('site.title')) }}
        @endif
    </title>

    @yield('css')
    {!! Script::renderCss() !!}
    {!! Script::globals() !!}
    <link rel="stylesheet" href="{{ theme_public_asset('css/main.css') }}">

    @yield('head_embed_code')
</head>
<body>
    <div class="loading">
        <div class="d-flex justify-content-center align-items-center hp-100">
            <div class="loader"></div>
        </div>
    </div>

    @include('partials.header')
    @include('partials.sidebar')
    
    <div class="main">

         @if(View::hasSection('sub_header') && View::hasSection('content') && View::hasSection('form'))
            @php
                // Decode the JSON attributes if provided
                $attributes = @json_decode( htmlspecialchars_decode( View::yieldContent('form') ), true) ?? [];
                // Convert to string format: key="value"
                $attributesString = collect($attributes)->map(function ($value, $key) {
                    return $key . '="' . e($value) . '"';
                })->implode(' ');
            @endphp

            <form {!! $attributesString !!}>
                @csrf

                @hasSection('sub_header')
                    <div class="border-bottom mb-5 bg-polygon">
                        <div class="container">
                            <div class="pt-4 pb-4">
                                @yield('sub_header')
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </form>
        @else
            @hasSection('sub_header')
                <div class="border-bottom mb-5 bg-polygon">
                    <div class="container">
                        <div class="pt-4 pb-4">
                            @yield('sub_header')
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        @endif
    </div>

    @include('partials.footer')

    <!-- FOOTER END -->
    <script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/maps/modules/map.js"></script>
    <script src="https://code.highcharts.com/mapdata/custom/world.js"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/codemirror5/lib/codemirror.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/codemirror5/mode/htmlmixed/htmlmixed.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/codemirror5/mode/php/php.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/codemirror5/mode/css/css.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/codemirror5/mode/javascript/javascript.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/codemirror5/mode/xml/xml.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/izitoast/js/iziToast.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/lodash/lodash.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/emojionearea/emojionearea.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/datetimepicker/timepicker-addon.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/ion.rangeSlider/js/ion.rangeSlider.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/inputTags/inputTags.jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/lazysizes/lazysizes.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/datatables/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('plugins/fullcalendar/index.global.min.js') }}"></script>
    <script type="text/javascript" src="{{ theme_public_asset('js/main.js') }}"></script>
    @yield('script')
    {!! Script::renderJs() !!}
    {!! Script::renderRaw() !!}
</body>
</html>