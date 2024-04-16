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
        Schema::create('patients', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->string('medical_record_number')->unique();
            $table->text('medical_history')->nullable();
            $table->foreignId('association_id')->nullable()->constrained('associations')->onDelete('cascade');
            $table->foreignId('disease_id')->nullable()->constrained('diseases')->onDelete('cascade');
            $table->jsonb('characteristics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
