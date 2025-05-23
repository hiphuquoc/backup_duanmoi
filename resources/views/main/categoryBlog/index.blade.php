@extends('layouts.wallpaper')
@push('cssFirstView')
    <!-- trường hợp là local thì dùng vite để chạy npm run dev lúc code -->
    @if(env('APP_ENV')=='local')
        @vite('resources/sources/main/category-blog-first-view.scss')
    @else
        @php
            $manifest           = json_decode(file_get_contents(public_path('build/manifest.json')), true);
            $cssFirstView       = $manifest['resources/sources/main/category-blog-first-view.scss']['file'];
        @endphp
        <style type="text/css">
            {!! file_get_contents(asset('build/' . $cssFirstView)) !!}
        </style>
    @endif
@endpush
@push('headCustom')
<!-- ===== START:: SCHEMA ===== -->
    <!-- STRAT:: Title - Description - Social -->
    @php
        $highPrice          = 0;
        $lowPrice           = $highPrice;
    @endphp
    @include('main.schema.social', ['item' => $item, 'lowPrice' => $lowPrice, 'highPrice' => $highPrice])
    <!-- END:: Title - Description - Social -->

    <!-- STRAT:: Title - Description - Social -->
    @include('main.schema.breadcrumb', compact('breadcrumb'))
    <!-- END:: Title - Description - Social -->

    <!-- STRAT:: Organization Schema -->
    @include('main.schema.organization')
    <!-- END:: Organization Schema -->

    <!-- STRAT:: Article Schema -->
    @include('main.schema.article', compact('item'))
    <!-- END:: Article Schema -->

    <!-- STRAT:: Article Schema -->
    @include('main.schema.creativeworkseries', compact('item'))
    <!-- END:: Article Schema -->

    <!-- STRAT:: FAQ Schema -->
    @include('main.schema.itemlist', ['data' => $blogs])
    <!-- END:: FAQ Schema -->

    <!-- STRAT:: FAQ Schema -->
    @include('main.schema.faq', ['data' => $item->faqs])
    <!-- END:: FAQ Schema -->
<!-- ===== END:: SCHEMA ===== -->
@endpush
@section('content')
    <!-- share social -->
    @include('main.template.shareSocial')
    <!-- content -->
    <div class="articleBox distanceBetweenBox">
        
        <div class="pageCategoryBlog distanceBetweenSubbox">
            <!-- breadcrumb -->
            @include('main.template.breadcrumb')
            <!-- thân trang -->
            <div class="layoutPageCategoryBlog">
                <div class="layoutPageCategoryBlog_left distanceBetweenSubbox">
                    <!-- tiêu đề -->
                    <h1 class="titlePage">{{ $itemSeo->title }}</h1>
                    <!-- sort -->
                    @include('main.categoryBlog.sort', [
                        'language'          => $language ?? 'vi',
                        'total'             => $item->blogs->count(),
                    ])
                    <!-- bài viết con -->
                    <div class="blogListBox">
                        @if(!empty($blogs)&&$blogs->count()>0)
                            @foreach($blogs as $blog)
                                @foreach($blog->seos as $seo)
                                    @if(!empty($seo->infoSeo->language)&&$seo->infoSeo->language==$language)
                                        @php
                                            $title = $seo->infoSeo->title ?? '';
                                            $urlArticle = env('APP_URL').'/'.$seo->infoSeo->slug_full;
                                        @endphp
                                        <div class="blogListBox_item">
                                            <a href="{{ $urlArticle }}" class="blogListBox_item_image">
                                                @if(!empty($blog->seo->image))
                                                    @php
                                                        $imageMini  = \App\Helpers\Image::getUrlImageMiniByUrlImage($blog->seo->image);
                                                        $imageSmall = \App\Helpers\Image::getUrlImageSmallByUrlImage($blog->seo->image);
                                                        $imageLarge = \App\Helpers\Image::getUrlImageLargeByUrlImage($blog->seo->image);
                                                    @endphp
                                                    <picture>
                                                        <source media="(max-width: 577px)" srcset="{{ $imageSmall }}">
                                                        <img 
                                                            class="lazyload" 
                                                            src="{{ $imageMini }}" 
                                                            data-src="{{ $imageLarge }}" 
                                                            alt="{{ $title }}" 
                                                            title="{{ $title }}" 
                                                            loading="lazy" 
                                                        />
                                                    </picture>
                                                @endif
                                            </a>
                                            <div class="blogListBox_item_content">
                                                <a href="{{ $urlArticle }}" class="blogListBox_item_content_title maxLine_2">
                                                    <h2>{{ $title }}</h2>
                                                </a>
                                                <div class="blogListBox_item_content_info">
                                                    <div class="maxLine_1">
                                                        <svg><use xlink:href="#icon_user"></use></svg>
                                                        Name Admin
                                                    </div> 
                                                    <div class="maxLine_1">
                                                        <svg><use xlink:href="#icon_clock_bold"></use></svg>
                                                        {!! date('d \t\h\á\n\g m, Y', strtotime($seo->infoSeo->created_at)) !!}
                                                    </div>
                                                    <div class="maxLine_1">
                                                        <svg style="transform: scale(1.15)"><use xlink:href="#icon_eye_bold"></use></svg>
                                                        {{ $item->viewed }}
                                                    </div> 
                                                    <div class="maxLine_1">
                                                        <svg style="transform: scale(1.1)"><use xlink:href="#icon_share"></use></svg>
                                                        {{ $item->shared }}
                                                    </div>
                                                </div>
                                                <div class="blogListBox_item_content_desc maxLine_4">
                                                    {!! !empty($seo->infoSeo->contents[0]->content) ? strip_tags($seo->infoSeo->contents[0]->content) : '' !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                            @endforeach
                        @else 
                            <div>{{ config('data_language_1.'.$language.'.no_suitable_results_found') }}</div>
                        @endif
                    </div>
                    
                </div>
                <!-- sidebar -->
                <div class="layoutPageCategoryBlog_right">
                    <!-- bai viết nổi bật -->
                    @if(!empty($blogFeatured)&&$blogFeatured->count()>0)
                        @include('main.categoryBlog.blogFeatured', compact('blogFeatured', 'language'))
                    @endif
                    <!-- danh sách category_blog -->
                    @if(!empty($categoriesLv2)&&$categoriesLv2->count()>0)
                        @include('main.categoryBlog.categoryBlogList', [
                            'categories'    => $categoriesLv2,
                            'language'      => $language,
                        ])
                    @endif
                </div>
            </div>

        </div>
        <!-- bài viết liên quan -->

    </div>

@endsection
@push('modal')
    {{-- <!-- Message Add to Cart -->
    <div id="js_addToCart_idWrite">
        @include('main.cart.cartMessage', [
            'title'     => null,
            'option'    => null,
            'quantity'  => 0,
            'price'     => 0,
            'image'     => null,
            'language'  => $language
        ])
    </div> --}}
@endpush
@push('bottom')
    <!-- Header bottom -->
    @include('main.snippets.headerBottom')
    <!-- === START:: Zalo Ring === -->
    {{-- @include('main.snippets.zaloRing') --}}
    <!-- === END:: Zalo Ring === -->
@endpush
@push('scriptCustom')
    <script type="text/javascript">
    
    </script>
@endpush