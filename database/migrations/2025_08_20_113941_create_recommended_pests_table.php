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
        Schema::create('recommended_pests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checklist_id');
            $table->unsignedBigInteger('panjikaran_id');
            $table->unsignedBigInteger('pest_id');
            $table->timestamps();

            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
            $table->foreign('panjikaran_id')->references('id')->on('panjikarans')->onDelete('cascade');
            $table->foreign('pest_id')->references('id')->on('pests')->onDelete('cascade');
            
            // Prevent duplicate entries for same panjikaran and pest
            $table->unique(['panjikaran_id', 'pest_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommended_pests');
    }
};