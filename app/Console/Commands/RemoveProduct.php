<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Http\Controllers\Admin\ProductController;

use Illuminate\Http\Request;
use App\Services\BuildInsertUpdateModel;

class RemoveProduct extends Command {
    
    protected $signature = 'run:remove_products';

    protected $description = 'Chạy job xóa các Product (chừa lại 1)';

    public function handle() {

        $products   = Product::select('*')
                        ->skip(1)
                        ->limit(PHP_INT_MAX)
                        ->get();

        $buildService   = new BuildInsertUpdateModel();
        $controller     = new ProductController($buildService);

        foreach ($products as $product) {
            $title      = $product->seo->title ?? '';
            $fakeRequest = new Request(['id' => $product->id]);
            $controller->delete($fakeRequest);
            $this->info('Đã xòa Product '.$title);
        }
        
        return 0;
    }
}
