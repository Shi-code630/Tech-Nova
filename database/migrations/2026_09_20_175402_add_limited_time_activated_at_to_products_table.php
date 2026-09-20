<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
        
            if (!Schema::hasColumn('products', 'limited_time_activated_at')) {
                $table->timestamp('limited_time_activated_at')
                    ->nullable()
                    ->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            if (Schema::hasColumn('products', 'limited_time_activated_at')) {
                $table->dropColumn('limited_time_activated_at');
            }
        });
    }
};
