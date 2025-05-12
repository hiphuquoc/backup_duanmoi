<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
@if(Route::is('main.confirm'))
    <meta name="robots" content="noindex,nofollow">
@else
    @if(!empty($index)&&$index=='no')
        <meta name="robots" content="noindex,nofollow">
    @else 
        <meta name="robots" content="index,follow">
    @endif
@endif
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="fragment" content="!" />
@if(!empty($language))
    <meta name="language" content="{{ $language }}" />
@endif
<!-- Dmca -->
<meta name='dmca-site-verification' content='{{ env('DMCA_VALIDATE') }}' />
{{-- <!-- Tối ưu hóa việc tải ảnh từ Google Cloud Storage -->
<link rel="preconnect" href="https://cdn.wallsora.com" crossorigin>
<link rel="dns-prefetch" href="https://cdn.wallsora.com"> --}}
<!-- Favicon -->
<link rel="shortcut icon" href="https://cdn.wallsora.com/storage/images/favicon-wallsora.webp" type="image/x-icon" />
<!-- view mode -->
<script src="{{ asset('js/viewMode.js') }}" async></script>

<!-- CSS Khung nhìn đầu tiên - Inline Css -->
@stack('cssFirstView')
<!-- Css tải sau -->
@stack('headCustom')
@if(env('APP_ENV')=='local')
    <!-- tải font nếu dev -->
    <style type="text/css">
        /* @font-face {
            font-family: 'Segoe-UI';
            font-style: normal;
            font-weight: 500;
            src: url('/fonts/SegoeUI.ttf');
            font-display: swap;
        }

        @font-face {
            font-family: 'Segoe-UI Semi';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url('/fonts/SegoeUI-SemiBold.ttf');
        }

        @font-face {
            font-family: 'Segoe-UI Bold';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url('/fonts/SegoeUI-Bold.ttf');
        } */

        @font-face {
            font-family: 'SVN-Gilroy';
            font-style: normal;
            font-display: swap;
            font-weight: 500;
            src: url('/fonts/svn-gilroy_medium.ttf');
        }

        @font-face {
            font-family: 'SVN-Gilroy Med';
            font-style: normal;
            font-display: swap;
            font-weight: 700;
            src: url('/fonts/svn-gilroy_med.ttf');
        }

        @font-face {
            font-family: 'SVN-Gilroy Semi';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url('/fonts/svn-gilroy_semibold.ttf');
        }

        @font-face {
            font-family: 'SVN-Gilroy Bold';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url('/fonts/svn-gilroy_semibold.ttf');
        }
        /* @font-face {
        font-family: 'MT';
        font-style: normal;
        font-weight: 700;
        font-display: swap;
        src: url('/fonts/mt-regular.otf'); */
    /* } */
    </style>
@endif
{{-- @include('main.snippets.fonts') --}}

<!-- START:: ===== GOOGLE FONTS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
<!-- END:: ===== GOOGLE FONTS -->
