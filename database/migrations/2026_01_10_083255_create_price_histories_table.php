<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('price_histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('package_id')
              ->constrained('service_packages')
              ->cascadeOnDelete();

        $table->decimal('old_price', 10, 2);
        $table->decimal('new_price', 10, 2);
        $table->text('reason')->nullable();

        $table->foreignId('changed_by')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_histories');
    }
};
