<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('order_number');
            }

            if (!Schema::hasColumn('orders', 'courier_name')) {
                $table->string('courier_name')->nullable()->after('tracking_number');
            }
             if (Schema::hasColumn('orders', 'address_id')) {
                $table->unsignedBigInteger('address_id')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['tracking_number', 'courier_name']);
        });
    }
};
