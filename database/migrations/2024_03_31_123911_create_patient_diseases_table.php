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
        // Schema::create('patient_diseases', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('patient_id');
        //     $table->unsignedBigInteger('disease_id');
        //     $table->timestamps();
        //     $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');
        //     $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_diseases');
    }
};
