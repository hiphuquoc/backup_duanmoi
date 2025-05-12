<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use App\Models\Page;
use App\Models\Category;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\HelperController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChatGptController;
use App\Models\ISO3166;
use App\Models\Tag;
use App\Models\Seo;
use App\Models\SeoContent;
use App\Models\Product;
use GeoIp2\Database\Reader;
use Illuminate\Support\Facades\Session;
use App\Models\RelationSeoProductInfo;
use App\Models\RelationSeoCategoryInfo;
use App\Models\RelationSeoTagInfo;
use App\Models\RelationSeoPageInfo;
use App\Models\Timezone;
use App\Jobs\Tmp;
use App\Jobs\AutoTranslateContent;
use App\Jobs\AutoImproveContent;
use App\Jobs\TranslateConfigLanguage;
use App\Jobs\CopyBoxContentToAllTagAndCategory;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendProductMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use App\Services\BuildInsertUpdateModel;

// use App\Models\RelationSeoTagInfo;
// use App\Models\RelationSeoPageInfo;
// use App\Models\Wallpaper;
// use Google\Client as Google_Client;
// use Illuminate\Support\Facades\DB;

// use Illuminate\Support\Facades\Mail;
// use App\Mail\SendProductMail;

// use DOMDocument;
// use PDO;
// use PhpParser\Node\Stmt\Switch_;

class HomeController extends Controller {
    public static function home(Request $request, $language = 'vi') {
        // 1. Ngôn ngữ và cấu hình
        SettingController::settingLanguage($language);

        $appName        = env('APP_NAME');

        $useCache       = env('APP_CACHE_HTML', true);
        $redisTtl       = config('app.cache_redis_time', 86400);     // Redis: 1 ngày
        $fileTtl        = config('app.cache_html_time', 2592000);    // GCS: 30 ngày

        // 2. Tạo key và đường dẫn cache
        $cacheKey     = RoutingController::buildNameCache("{$language}home");
        $cacheName    = $cacheKey . '.' . config("main_{$appName}.cache.extension");
        $cacheFolder  = config("main_{$appName}.cache.folderSave");
        $cachePath    = $cacheFolder . $cacheName;
        $cdnDomain    = config("main_{$appName}.google_cloud_storage.cdn_domain");

        $disk         = Storage::disk(config("main_{$appName}.cache.disk"));
        $htmlContent  = null;

        // 3. Thử lấy từ Redis
        if ($useCache && Cache::has($cacheKey)) {
            $htmlContent = Cache::get($cacheKey);
        }

        // 4. Nếu không có Redis → thử từ GCS (qua CDN)
        if ($useCache && !$htmlContent && $disk->exists($cachePath)) {
            $lastModified = $disk->lastModified($cachePath);
            if ((time() - $lastModified) < $fileTtl) {
                $htmlContent = @file_get_contents($cdnDomain . $cachePath);
                if ($htmlContent) {
                    Cache::put($cacheKey, $htmlContent, $redisTtl);
                }
            }
        }

        // 5. Nếu không có cache → Render
        if (!$htmlContent) {
            $item = Page::select('*')
                ->whereHas('seos.infoSeo', function ($query) use ($language) {
                    $query->where('slug', $language);
                })
                ->with('seo', 'seos.infoSeo', 'type')
                ->first();

            $itemSeo = self::extractSeoForLanguage($item, $language);

            $categories = Category::select('*')
                ->where('flag_show', 1)
                ->get();

            $htmlContent = view('main.home.index', compact('item', 'itemSeo', 'language', 'categories'))->render();

            // Lưu cache lại nếu bật
            if ($useCache) {
                Cache::put($cacheKey, $htmlContent, $redisTtl);
                $disk->put($cachePath, $htmlContent);
            }
        }

        echo $htmlContent;
    }

    /**
        * Trích xuất infoSeo đúng ngôn ngữ
    */
    public static function extractSeoForLanguage($item, $language) {
        if (empty($item->seos)) {
            return [];
        }

        foreach ($item->seos as $seo) {
            if (!empty($seo->infoSeo->language) && $seo->infoSeo->language === $language) {
                return $seo->infoSeo;
            }
        }

        return [];
    }

    public static function test(Request $request) {
        $categories = Category::whereHas('seo', function($query){
                            $query->where('level', '>', 1);
                        })->get();

        $buildService = new BuildInsertUpdateModel();
        $controller = new CategoryController($buildService);

        foreach ($categories as $category) {
            $fakeRequest = new Request(['id' => $category->id]);
            $controller->delete($fakeRequest);
        }

        return 'Done';
    }

    public static function chatWithAI(array $messages, string $model = 'deepseek-reasoner', array $options = []) {
        // $apiUrl = "https://api.deepseek.com/chat/completions";
        $apiUrl = "https://dashscope-intl.aliyuncs.com/compatible-mode/v1/chat/completions";
        $apiKey = env('QWEN_API_KEY'); // Đặt API key trong file .env
    
        $payload = array_merge([
            'model' => $model,
            'messages' => $messages,
        ], $options);
    
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $apiKey",
        ])->timeout(3060)->post($apiUrl, $payload);
    
        if ($response->successful()) {
            return $response->json();
        }
        
        return ['error' => 'Failed to connect to DeepInfra API', 'status' => $response->status(), 'body' => $response->body()];
    }

    private static function normalizeUnicode($string) {
        return \Normalizer::normalize($string, \Normalizer::FORM_C);
    }

    public static function callAPIClaudeAI(Request $request){

        // Cấu hình Guzzle client
        $client = new Client();

        // Lấy API key từ .env
        $apiKey = env('CLAUDE_AI_API_KEY');

        // Dữ liệu bạn muốn gửi đến Claude AI API
        $data = [
            'model' => 'claude-3-5-sonnet-20241022',
            'max_tokens' => 1024,
            'messages' => [
                ['role' => 'user', 'content' => '1 + 1 bằng mấy'], 
            ],
        ];

        // Gửi yêu cầu POST đến Claude AI API
        $response = $client->post('https://api.anthropic.com/v1/messages', [
            'headers' => [
                'x-api-key' => $apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ],
            'json' => $data,
        ]);

        // Trả về kết quả từ API dưới dạng JSON
        $result = response()->json(json_decode($response->getBody()->getContents(), true));

        dd($result);
        
    }

    private static function findUniqueElements($arr1, $arr2) {
        // Lọc các phần tử có trong arr1 nhưng không có trong arr2 và ngược lại
        $uniqueInArr1 = array_diff($arr1, $arr2);
        $uniqueInArr2 = array_diff($arr2, $arr1);
        
        // Kết hợp các phần tử không trùng
        return array_merge($uniqueInArr1, $uniqueInArr2);
    }
}