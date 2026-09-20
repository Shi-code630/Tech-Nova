<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('resume_path');
            $table->text('message')->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, shortlisted, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
