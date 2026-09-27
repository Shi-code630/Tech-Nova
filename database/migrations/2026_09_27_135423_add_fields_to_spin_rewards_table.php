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
    Schema::table('spin_rewards', function (Blueprint $table) {
        $table->string('name')->after('id');

        $table->enum('type', [
            'discount',
            'coins',
            'gift',
        ])->after('name');

        $table->unsignedInteger('discount_percent')
            ->nullable()
            ->after('type');

        $table->unsignedInteger('coins')
            ->nullable()
            ->after('discount_percent');

        $table->text('description')
            ->nullable()
            ->after('coins');

        $table->unsignedInteger('stock')
            ->nullable()
            ->after('description');

        $table->decimal('probability', 8, 4)
            ->default(0)
            ->after('stock');

        $table->boolean('status')
            ->default(true)
            ->after('probability');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('spin_rewards', function (Blueprint $table) {
        $table->dropColumn([
            'name',
            'type',
            'discount_percent',
            'coins',
            'description',
            'stock',
            'probability',
            'status',
        ]);
    });
}
};
