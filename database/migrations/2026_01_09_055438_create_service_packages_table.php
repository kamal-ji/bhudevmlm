<?php
// database/migrations/xxxx_xx_xx_create_service_packages_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('duration_days')->nullable();
            $table->decimal('commission_amount', 10, 2)->nullable();
            $table->decimal('commission_percentage', 5, 2)->nullable();
            $table->enum('commission_type', ['percentage', 'fixed', 'both'])->default('percentage');
            $table->json('features')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_packages');
    }
};