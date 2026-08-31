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
        Schema::create('order_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained()
                ->onDelete('cascade')
            ;
            $table->enum('status', [
                'pending',
                'processing',
                'confirmed',
                'shipped',
                'out_for_delivery',
                'delivered',
                'cancelled',
                'returned'

            ])->default('pending');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('status_date')->useCurrent();
            $table->timestamps();
            $table->index(['order_id', 'status']);
            if (!Schema::hasColumn('order_trackings', 'tracked_at')) {
                $table->timestamp('tracked_at')->nullable()->after('note');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_trackings');
    }
};
