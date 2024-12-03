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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->string('student_identification_code');
            $table->string('student_code');
            $table->string('full_name');
            $table->boolean('gender');
            $table->date('birth_date');
            $table->string('birthplace');
            $table->string('address');
            $table->string('guardian_full_name');
            $table->string('guardian_phone');
            $table->string('student_face_url') -> nullable();
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
