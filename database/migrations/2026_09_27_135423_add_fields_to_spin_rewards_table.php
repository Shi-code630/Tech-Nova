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
        // 👇 Step 1: Table नै छैन भने पूरै table create गर्ने
        if (!Schema::hasTable('spin_rewards')) {
            Schema::create('spin_rewards', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->enum('type', ['discount', 'coins', 'gift']);
                $table->unsignedInteger('discount_percent')->nullable();
                $table->unsignedInteger('coins')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('stock')->nullable();
                $table->decimal('probability', 8, 4)->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
            return; // 👈 Create सकेपछि अरू केही नगर्ने
        }

        // 👇 Step 2: Table छ भने columns check गरेर थप्ने
        Schema::table('spin_rewards', function (Blueprint $table) {
            if (!Schema::hasColumn('spin_rewards', 'name')) {
                $table->string('name')->after('id');
            }

            if (!Schema::hasColumn('spin_rewards', 'type')) {
                $table->enum('type', ['discount', 'coins', 'gift'])->after('name');
            }

            if (!Schema::hasColumn('spin_rewards', 'discount_percent')) {
                $table->unsignedInteger('discount_percent')->nullable()->after('type');
            }

            if (!Schema::hasColumn('spin_rewards', 'coins')) {
                $table->unsignedInteger('coins')->nullable()->after('discount_percent');
            }

            if (!Schema::hasColumn('spin_rewards', 'description')) {
                $table->text('description')->nullable()->after('coins');
            }

            if (!Schema::hasColumn('spin_rewards', 'stock')) {
                $table->unsignedInteger('stock')->nullable()->after('description');
            }

            if (!Schema::hasColumn('spin_rewards', 'probability')) {
                $table->decimal('probability', 8, 4)->default(0)->after('stock');
            }

            if (!Schema::hasColumn('spin_rewards', 'status')) {
                $table->boolean('status')->default(true)->after('probability');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spin_rewards');
    }
};
