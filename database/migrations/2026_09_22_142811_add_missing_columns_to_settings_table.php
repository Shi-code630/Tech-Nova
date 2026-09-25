<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            $table->string('currency', 10)
                ->default('NPR')
                ->after('address');

            $table->string('currency_symbol', 10)
                ->nullable()
                ->after('currency');

            $table->string('payment_gateway')
                ->nullable()
                ->after('currency_symbol');

            $table->decimal('default_shipping_charge', 10, 2)
                ->default(0)
                ->after('payment_gateway');

            $table->boolean('free_shipping')
                ->default(false)
                ->after('default_shipping_charge');

            $table->decimal('free_shipping_threshold', 10, 2)
                ->nullable()
                ->after('free_shipping');

            $table->string('smtp_host')
                ->nullable()
                ->after('free_shipping_threshold');

            $table->unsignedInteger('smtp_port')
                ->nullable()
                ->after('smtp_host');

            $table->string('smtp_username')
                ->nullable()
                ->after('smtp_port');

            $table->string('smtp_password')
                ->nullable()
                ->after('smtp_username');

            $table->string('smtp_encryption')
                ->nullable()
                ->after('smtp_password');

            $table->string('meta_title')
                ->nullable()
                ->after('smtp_encryption');

            $table->text('meta_description')
                ->nullable()
                ->after('meta_title');

            $table->text('meta_keywords')
                ->nullable()
                ->after('meta_description');

            $table->string('youtube')
                ->nullable()
                ->after('linkedin');

            $table->boolean('maintenance_mode')
                ->default(false)
                ->after('youtube');

            $table->text('maintenance_message')
                ->nullable()
                ->after('maintenance_mode');

            $table->string('timezone')
                ->nullable()
                ->after('maintenance_message');

            $table->string('date_format')
                ->nullable()
                ->after('timezone');

            $table->string('time_format')
                ->nullable()
                ->after('date_format');

            $table->text('footer_text')
                ->nullable()
                ->after('copyright');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'currency',
                'currency_symbol',
                'payment_gateway',
                'default_shipping_charge',
                'free_shipping',
                'free_shipping_threshold',
                'smtp_host',
                'smtp_port',
                'smtp_username',
                'smtp_password',
                'smtp_encryption',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'youtube',
                'maintenance_mode',
                'maintenance_message',
                'timezone',
                'date_format',
                'time_format',
                'footer_text',
            ]);
        });
    }
}; 
