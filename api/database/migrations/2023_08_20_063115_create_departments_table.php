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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('course')->comment('学科名');
            $table->unsignedTinyInteger('grade')->comment('学年');
            $table->unsignedTinyInteger('fiscal_year')->comment('稼働年度');
            $table->unsignedBigInteger('school_id')->comment('学校ID');
            $table->timestamps();
            $table->comment('学科');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
