<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // General Settings
            $table->string('site_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            // Payment Settings
            $table->string('currency')->default('NPR');
            $table->string('currency_symbol')->default('Rs.');
            $table->string('payment_gateway')->nullable();

            // Shipping Settings
            $table->decimal('default_shipping_charge', 10, 2)->default(0);
            $table->boolean('free_shipping')->default(false);
            $table->decimal('free_shipping_threshold', 10, 2)->default(0);

            // Email Settings
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_encryption')->nullable();

            // SEO Settings
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Social Media
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();

            // Security & Maintenance
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();

            // Timezone & Format
            $table->string('timezone')->default('Asia/Kathmandu');
            $table->string('date_format')->default('d M, Y');
            $table->string('time_format')->default('h:i A');

            // Other
            $table->string('copyright')->nullable();
            $table->string('footer_text')->nullable();
            $table->json('additional_settings')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
