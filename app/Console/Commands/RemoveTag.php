<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tag;
use App\Http\Controllers\Admin\TagController;

use Illuminate\Http\Request;
use App\Services\BuildInsertUpdateModel;

class RemoveTag extends Command {
    
    protected $signature = 'run:remove_tags';

    protected $description = 'Chạy job xóa các tag (chừa lại 1)';

    public function handle() {

        $tags   = Tag::select('*')
                    ->skip(1)
                    ->limit(PHP_INT_MAX)
                    ->get();

        $buildService   = new BuildInsertUpdateModel();
        $controller     = new TagController($buildService);

        foreach ($tags as $tag) {
            $title      = $tag->seo->title ?? '';
            $fakeRequest = new Request(['id' => $tag->id]);
            $controller->delete($fakeRequest);
            $this->info('Đã xòa tag '.$title);
        }

        
        return 0;
    }
}
