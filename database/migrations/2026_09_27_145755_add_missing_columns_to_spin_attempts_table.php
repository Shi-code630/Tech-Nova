<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 👇 Step 1: Table नै छैन भने पूरै table create गर्ने
        if (!Schema::hasTable('spin_attempts')) {
            Schema::create('spin_attempts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('spin_reward_id')->nullable();
                $table->string('reward_name')->nullable();
                $table->string('status')->default('won');
                $table->timestamp('claimed_at')->nullable();
                $table->timestamps();
            });
            return; // 👈 Create सकेपछि अरू केही नगर्ने
        }

        // 👇 Step 2: Table छ भने columns check गरेर थप्ने
        Schema::table('spin_attempts', function (Blueprint $table) {
            if (!Schema::hasColumn('spin_attempts', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
            }

            if (!Schema::hasColumn('spin_attempts', 'spin_reward_id')) {
                $table->unsignedBigInteger('spin_reward_id')->nullable();
            }

            if (!Schema::hasColumn('spin_attempts', 'reward_name')) {
                $table->string('reward_name')->nullable();
            }

            if (!Schema::hasColumn('spin_attempts', 'status')) {
                $table->string('status')->default('won');
            }

            if (!Schema::hasColumn('spin_attempts', 'claimed_at')) {
                $table->timestamp('claimed_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spin_attempts');
    }
};
