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
        Schema::create('department_heads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->comment('対象学科ID');
            $table->unsignedBigInteger('teacher_id')->comment('学科を受け持つ教師ID');
            $table->timestamps();
            $table->comment('学科やクラスを受け持つ教師');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_heads');
    }
};
