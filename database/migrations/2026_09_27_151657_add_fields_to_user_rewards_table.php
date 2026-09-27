<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_rewards', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->after('id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('spin_reward_id')
                ->after('user_id')
                ->constrained('spin_rewards')
                ->cascadeOnDelete();

            $table->foreignId('spin_attempt_id')
                ->after('spin_reward_id')
                ->constrained('spin_attempts')
                ->cascadeOnDelete();

            $table->string('reward_name')->after('spin_attempt_id');

            $table->string('reward_type')->after('reward_name');

            $table->unsignedInteger('coins')->nullable()->after('reward_type');

            $table->string('status')->default('claimed')->after('coins');

            $table->timestamp('claimed_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('user_rewards', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['spin_reward_id']);
            $table->dropForeign(['spin_attempt_id']);

            $table->dropColumn([
                'user_id',
                'spin_reward_id',
                'spin_attempt_id',
                'reward_name',
                'reward_type',
                'coins',
                'status',
                'claimed_at',
            ]);
        });
    }
};
