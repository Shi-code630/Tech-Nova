<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->json('images')->nullable()->after('image');
        });

        $rows = DB::table('product_variants')->whereNotNull('image')->get();

        foreach ($rows as $row) {
            if (!$row->image) {
                continue;
            }

            $decoded = json_decode($row->image, true);
            $gallery = is_array($decoded) ? $decoded : [$row->image];

            DB::table('product_variants')->where('id', $row->id)->update([
                'images' => json_encode(array_values($gallery)),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
