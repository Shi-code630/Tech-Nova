<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
           
            if (!Schema::hasColumn('orders', 'reward_points_given')) {
                $table->boolean('reward_points_given')->default(false)->after('order_status');
            }

            if (!Schema::hasColumn('orders', 'reward_points_earned')) {
                $table->unsignedInteger('reward_points_earned')->default(0)->after('reward_points_given');
            }
            if (Schema::hasColumn('orders', 'address_id')) {
                $table->foreignId('address_id')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['reward_points_given', 'reward_points_earned']);
        });
    }
};
