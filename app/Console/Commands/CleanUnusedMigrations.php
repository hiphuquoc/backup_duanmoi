<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CleanUnusedMigrations extends Command
{
    protected $signature = 'migration:clean-unused {--dry-run : Chỉ hiển thị những gì sẽ xoá mà không thực hiện}';
    protected $description = 'Xoá các migration đã ghi trong DB nhưng không còn file tương ứng, xoá bảng và model nếu có thể';

    public function handle()
    {
        $this->info('🔍 Đang kiểm tra các migration không còn file...');

        // Lấy danh sách file migration hiện tại
        $migrationFiles = collect(File::files(database_path('migrations')))
            ->map(fn($file) => pathinfo($file, PATHINFO_FILENAME))
            ->toArray();

        // Lấy danh sách migration trong DB
        $migrationInDb = DB::table('migrations')->pluck('migration')->toArray();

        // Tìm migration không còn file
        $missingMigrations = array_diff($migrationInDb, $migrationFiles);

        if (empty($missingMigrations)) {
            $this->info('✅ Không có migration nào cần xoá.');
            return 0;
        }

        $isDryRun = $this->option('dry-run');

        $this->warn('❌ Các migration không còn file:');
        foreach ($missingMigrations as $migration) {
            $this->line("- $migration");

            // Tìm bảng tương ứng nếu tên migration là create_xxx_table
            if (preg_match('/create_(.*)_table/', $migration, $matches)) {
                $table = $matches[1];

                // Dự đoán tên model từ tên bảng
                $modelName = Str::studly(Str::singular($table));
                $modelPath = app_path("Models/{$modelName}.php");

                if (!$isDryRun) {
                    // Xoá bảng
                    if (Schema::hasTable($table)) {
                        Schema::drop($table);
                        $this->warn("  → Đã xoá bảng `$table`");
                    } else {
                        $this->line("  → Bảng `$table` không tồn tại");
                    }

                    // Xoá model
                    if (File::exists($modelPath)) {
                        File::delete($modelPath);
                        $this->warn("  → Đã xoá model `$modelName` tại Models/");
                    } else {
                        $this->line("  → Model `$modelName` không tồn tại");
                    }
                } else {
                    $this->line("  → (dry-run) Sẽ xoá bảng `$table` nếu tồn tại");
                    $this->line("  → (dry-run) Sẽ xoá model `$modelName` nếu tồn tại tại Models/");
                }
            }
        }

        if (!$isDryRun) {
            // Xoá bản ghi trong bảng migrations
            DB::table('migrations')->whereIn('migration', $missingMigrations)->delete();
            $this->info("🧹 Đã xoá " . count($missingMigrations) . " bản ghi khỏi bảng `migrations`.");
        } else {
            $this->info("✅ (dry-run) Hoàn tất. Không có gì bị xoá.");
        }

        return 0;
    }
}
