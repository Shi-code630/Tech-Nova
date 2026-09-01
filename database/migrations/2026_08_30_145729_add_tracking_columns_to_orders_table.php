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
        Schema::table('orders', function (Blueprint $table) {
            
            if (!Schema::hasColumn('orders', 'shipped_at')) {
                $table->timestamp('shipped_at')->nullable()->after('current_location');
            }

            
            if (!Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $columns = [];

            if (Schema::hasColumn('orders', 'shipped_at')) {
                $columns[] = 'shipped_at';
            }
            if (Schema::hasColumn('orders', 'delivered_at')) {
                $columns[] = 'delivered_at';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
