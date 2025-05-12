<!DOCTYPE html>
<html lang="{{ $language ?? 'vi' }}" dir="{{ config('language.'.$language.'.dir') }}">   
    
{{-- class="{{ request()->cookie('view_mode') ?? config('main_'.env('APP_NAME').'.view_mode')[0]['key'] }}" --}}

<!-- === START:: Head === -->
<head>
    @include('main.snippets.head')
</head>
<!-- === END:: Head === -->

<!-- === START:: Body === -->
<body class="background">

    <!-- SVG icon inline -->
    @include('main.snippets.svgSprite')
    
    <div id="js_openCloseModal_blur">
        <!-- === START:: Header === -->
        @include('main.snippets.headerTop')
        @include('main.snippets.headerMain')
        <!-- === END:: Header === -->

        <!-- === START:: Breadcrumb === -->
        {{-- @if(Route::current()->uri!=='/')
            @include('snippets.breadcrumb')
        @endif --}}
        <!-- === END:: Breadcrumb === -->

        <!-- === START:: Content === -->
        <div class="app-content content">
            <div class="content-overlay"></div>
            @yield('content')
        </div>

        {{-- <!-- === START:: Footer === -->
        @include('main.snippets.footer')
        <!-- === END:: Footer === -->

        <div class="bottom">
            <div id="gotoTop" class="gotoTop" onclick="javascript:gotoTop();" style="display: block;">
                <i class="fas fa-chevron-up"></i>
            </div>
            @stack('bottom')
        </div> --}}

    </div>

    {{-- <!-- Full loading -->
    <div id="js_toggleFullLoading" class="fullLoading">
        <div class="fullLoading_box">
            <div class="loadingIcon"></div>
            <div id="js_toggleFullLoading_text" class="fullLoading_box_text">{{ config('data_language_3.'.$language.'.the_system_is_processing_your_request') }}</div>
        </div>
    </div> --}}
    
    <!-- Modal -->
    @stack('modal')

    <!-- login form modal -->
    <div id="js_checkLoginAndSetShow_modal">
        <!-- tải ajaax checkLoginAndSetShow() -->
    </div>

    <!-- === START:: Scripts Default === -->
    @include('main.snippets.scriptDefault')
    <!-- === END:: Scripts Default === -->

    <!-- === START:: Scripts Custom === -->
    @stack('scriptCustom')
    <!-- === END:: Scripts Custom === -->
    
</body>
<!-- === END:: Body === -->

</html>