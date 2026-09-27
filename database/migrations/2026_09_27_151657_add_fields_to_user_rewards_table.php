<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 👇 Step 1: Table नै छैन भने पूरै table create गर्ने
        if (!Schema::hasTable('user_rewards')) {
            Schema::create('user_rewards', function (Blueprint $table) {
                $table->id();

                $table->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->foreignId('spin_reward_id')
                    ->constrained('spin_rewards')
                    ->cascadeOnDelete();

                $table->foreignId('spin_attempt_id')
                    ->constrained('spin_attempts')
                    ->cascadeOnDelete();

                $table->string('reward_name');
                $table->string('reward_type');
                $table->unsignedInteger('coins')->nullable();
                $table->string('status')->default('claimed');
                $table->timestamp('claimed_at')->nullable();
                $table->timestamps();
            });
            return; // 👈 Create सकेपछि अरू केही नगर्ने
        }

        // 👇 Step 2: Table छ भने columns check गरेर थप्ने
        Schema::table('user_rewards', function (Blueprint $table) {
            if (!Schema::hasColumn('user_rewards', 'user_id')) {
                $table->foreignId('user_id')
                    ->after('id')
                    ->constrained('users')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('user_rewards', 'spin_reward_id')) {
                $table->foreignId('spin_reward_id')
                    ->after('user_id')
                    ->constrained('spin_rewards')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('user_rewards', 'spin_attempt_id')) {
                $table->foreignId('spin_attempt_id')
                    ->after('spin_reward_id')
                    ->constrained('spin_attempts')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('user_rewards', 'reward_name')) {
                $table->string('reward_name')->after('spin_attempt_id');
            }

            if (!Schema::hasColumn('user_rewards', 'reward_type')) {
                $table->string('reward_type')->after('reward_name');
            }

            if (!Schema::hasColumn('user_rewards', 'coins')) {
                $table->unsignedInteger('coins')->nullable()->after('reward_type');
            }

            if (!Schema::hasColumn('user_rewards', 'status')) {
                $table->string('status')->default('claimed')->after('coins');
            }

            if (!Schema::hasColumn('user_rewards', 'claimed_at')) {
                $table->timestamp('claimed_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_rewards');
    }
};
