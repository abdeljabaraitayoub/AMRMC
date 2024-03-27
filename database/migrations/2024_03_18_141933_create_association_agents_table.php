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
        Schema::create('association_agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('association_id')->nullable()->constrained('associations')->onDelete('cascade');
            $table->enum('position', ['president', 'member'])->default('member');
            $table->text('bio')->nullable()->nullable();
            $table->timestamps();
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('association_agents');
    }
};
