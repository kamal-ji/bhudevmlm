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
    Schema::create('service_orders', function (Blueprint $table) {
        $table->increments('id'); // int AUTO_INCREMENT PRIMARY KEY

        $table->string('order_number', 50)->nullable()->unique();

        $table->integer('member_id')->nullable();
        $table->integer('service_package_id')->nullable();
        $table->integer('service_category_id')->nullable();
        $table->integer('referrer_id')->nullable();

        $table->decimal('amount', 10, 2)->nullable();
        $table->decimal('commission_amount', 10, 2)->nullable();

        $table->boolean('commission_paid')->default(false);

        $table->enum('status', ['pending', 'completed', 'cancelled'])
              ->default('pending');

        $table->string('referral_code_used', 50)->nullable();

        $table->timestamp('order_date')->nullable()->useCurrent();

        $table->dateTime('created_at')->useCurrent();

        // Indexes
        $table->index('member_id');
        $table->index('service_package_id');
        $table->index('service_category_id');
        $table->index('referrer_id');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
