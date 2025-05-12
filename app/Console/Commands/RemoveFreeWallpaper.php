<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FreeWallpaper;
use App\Http\Controllers\Admin\FreeWallpaperController;

use Illuminate\Http\Request;
use App\Services\BuildInsertUpdateModel;

class RemoveFreeWallpaper extends Command {
    
    protected $signature = 'run:remove_freewallpapers';

    protected $description = 'Chạy job xóa các FreeWallpaper (chừa lại 1)';

    public function handle() {

        $freeWallpapers = FreeWallpaper::select('*')
                            ->skip(1)
                            ->limit(PHP_INT_MAX)
                            ->get();

        $buildService   = new BuildInsertUpdateModel();
        $controller     = new FreeWallpaperController($buildService);

        foreach ($freeWallpapers as $freeWallpaper) {
            $title      = $freeWallpaper->seo->title ?? '';
            $fakeRequest = new Request(['id' => $freeWallpaper->id]);
            $controller->deleteWallpaper($fakeRequest);
            $this->info('Đã xòa FreeWallpaper '.$title);
        }
        
        return 0;
    }
}
