<?php
// database/migrations/xxxx_xx_xx_create_service_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('icon')->default('isax-category');
            $table->string('color')->default('#4dabf7');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_categories');
    }
};