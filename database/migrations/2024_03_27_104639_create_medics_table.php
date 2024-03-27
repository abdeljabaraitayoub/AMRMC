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
        Schema::create('medics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->enum('dosage_form', ['tablet', 'capsule', 'liquid']);
            $table->string('manufacturer');
            $table->decimal('price', 8, 2);
            $table->text('description')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medics');
    }
};