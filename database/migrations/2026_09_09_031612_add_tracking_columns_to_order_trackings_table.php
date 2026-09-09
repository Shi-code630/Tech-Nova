<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_trackings', function (Blueprint $table) {
            
            if (!Schema::hasColumn('order_trackings', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('order_id');
            }


            if (!Schema::hasColumn('order_trackings', 'courier_name')) {
                $table->string('courier_name')->nullable()->after('tracking_number');
            }


            if (!Schema::hasColumn('order_trackings', 'status_date')) {
                $table->timestamp('status_date')->nullable()->after('note');
            }
        });
    }

    public function down(): void
    {
        Schema::table('order_trackings', function (Blueprint $table) {
            $table->dropColumn(['tracking_number', 'courier_name', 'status_date']);
        });
    }
};
