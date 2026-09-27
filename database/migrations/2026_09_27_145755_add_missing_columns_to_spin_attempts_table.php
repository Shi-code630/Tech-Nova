<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spin_attempts', function (Blueprint $table) {

            if (! Schema::hasColumn('spin_attempts', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
            }

            if (! Schema::hasColumn('spin_attempts', 'spin_reward_id')) {
                $table->unsignedBigInteger('spin_reward_id')->nullable();
            }

            if (! Schema::hasColumn('spin_attempts', 'reward_name')) {
                $table->string('reward_name')->nullable();
            }

            if (! Schema::hasColumn('spin_attempts', 'status')) {
                $table->string('status')->default('won');
            }

            if (! Schema::hasColumn('spin_attempts', 'claimed_at')) {
                $table->timestamp('claimed_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('spin_attempts', function (Blueprint $table) {

            if (Schema::hasColumn('spin_attempts', 'user_id')) {
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('spin_attempts', 'spin_reward_id')) {
                $table->dropColumn('spin_reward_id');
            }

            if (Schema::hasColumn('spin_attempts', 'reward_name')) {
                $table->dropColumn('reward_name');
            }

            if (Schema::hasColumn('spin_attempts', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('spin_attempts', 'claimed_at')) {
                $table->dropColumn('claimed_at');
            }
        });
    }
};
