<?php
//database/migrations/xxxx_xx_xx_create_member_service_categories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('member_service_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_category_id')->constrained()->onDelete('cascade');
            $table->string('referral_code')->unique();
            $table->decimal('commission_rate', 5, 2)->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->decimal('total_sales', 10, 2)->default(0);
            $table->decimal('total_commission', 10, 2)->default(0);
            $table->integer('referral_count')->default(0);
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamps();
            
            $table->unique(['member_id', 'service_category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('member_service_categories');
    }
};