<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_method_info', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20);
            $table->text('name');
            $table->text('description');
            $table->text('en_name');
            $table->text('en_description');
            $table->text('icon')->nullable();
            $table->boolean('active')->default(0);
            $table->text('fee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('payment_method_info');
    }
};
