<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('banners', 'position')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->integer('position')->default(1)->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('banners', 'position')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->dropColumn('position');
            });
        }
    }
};
