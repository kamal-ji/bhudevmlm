<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('smtp_host'); // SMTP server address
            $table->string('smtp_port'); // SMTP port number
            $table->string('smtp_username'); // SMTP username
            $table->string('smtp_password'); // SMTP password
            $table->string('smtp_encryption')->nullable(); // Encryption type (SSL/TLS)
            $table->string('from_address'); // The default "from" email address
            $table->string('from_name'); // The default "from" name
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_settings');
    }
};
