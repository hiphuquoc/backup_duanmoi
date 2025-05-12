<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Http\Controllers\Admin\CategoryController;

use Illuminate\Http\Request;
use App\Services\BuildInsertUpdateModel;

class RemoveCategory extends Command {
    
    protected $signature = 'run:remove_categories';

    protected $description = 'Chạy job xóa các category (chừa lại 1)';

    public function handle() {

        $categories = Category::whereHas('seo', function($query){
                            $query->where('level', '>', 1);
                        })->get();

        $buildService   = new BuildInsertUpdateModel();
        $controller     = new CategoryController($buildService);

        foreach ($categories as $category) {
            $title      = $category->seo->title ?? '';
            $fakeRequest = new Request(['id' => $category->id]);
            $controller->delete($fakeRequest);
            $this->info('Đã xòa category '.$title);
        }
        
        return 0;
    }
}
