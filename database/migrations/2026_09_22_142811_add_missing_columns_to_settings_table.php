<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            if (!Schema::hasColumn('settings', 'currency')) {
                $table->string('currency', 10)->default('NPR')->after('address');
            }

            if (!Schema::hasColumn('settings', 'currency_symbol')) {
                $table->string('currency_symbol', 10)->nullable()->after('currency');
            }

            if (!Schema::hasColumn('settings', 'payment_gateway')) {
                $table->string('payment_gateway')->nullable()->after('currency_symbol');
            }

            if (!Schema::hasColumn('settings', 'default_shipping_charge')) {
                $table->decimal('default_shipping_charge', 10, 2)->default(0)->after('payment_gateway');
            }

            if (!Schema::hasColumn('settings', 'free_shipping')) {
                $table->boolean('free_shipping')->default(false)->after('default_shipping_charge');
            }

            if (!Schema::hasColumn('settings', 'free_shipping_threshold')) {
                $table->decimal('free_shipping_threshold', 10, 2)->nullable()->after('free_shipping');
            }

            if (!Schema::hasColumn('settings', 'smtp_host')) {
                $table->string('smtp_host')->nullable()->after('free_shipping_threshold');
            }

            if (!Schema::hasColumn('settings', 'smtp_port')) {
                $table->unsignedInteger('smtp_port')->nullable()->after('smtp_host');
            }

            if (!Schema::hasColumn('settings', 'smtp_username')) {
                $table->string('smtp_username')->nullable()->after('smtp_port');
            }

            if (!Schema::hasColumn('settings', 'smtp_password')) {
                $table->string('smtp_password')->nullable()->after('smtp_username');
            }

            if (!Schema::hasColumn('settings', 'smtp_encryption')) {
                $table->string('smtp_encryption')->nullable()->after('smtp_password');
            }

            if (!Schema::hasColumn('settings', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('smtp_encryption');
            }

            if (!Schema::hasColumn('settings', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }

            if (!Schema::hasColumn('settings', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }

            if (!Schema::hasColumn('settings', 'youtube')) {
                $table->string('youtube')->nullable()->after('linkedin');
            }

            if (!Schema::hasColumn('settings', 'maintenance_mode')) {
                $table->boolean('maintenance_mode')->default(false)->after('youtube');
            }

            if (!Schema::hasColumn('settings', 'maintenance_message')) {
                $table->text('maintenance_message')->nullable()->after('maintenance_mode');
            }

            if (!Schema::hasColumn('settings', 'timezone')) {
                $table->string('timezone')->nullable()->after('maintenance_message');
            }

            if (!Schema::hasColumn('settings', 'date_format')) {
                $table->string('date_format')->nullable()->after('timezone');
            }

            if (!Schema::hasColumn('settings', 'time_format')) {
                $table->string('time_format')->nullable()->after('date_format');
            }

            if (!Schema::hasColumn('settings', 'footer_text')) {
                $table->text('footer_text')->nullable()->after('copyright');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            $columnsToDrop = [];

            foreach ([
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
            ] as $column) {
                if (Schema::hasColumn('settings', $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
