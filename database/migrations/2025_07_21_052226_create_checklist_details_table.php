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
        Schema::create('checklist_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ChecklistID');
            $table->unsignedBigInteger('ChecklistItemID');
            $table->enum('DocumentStatus', [0, 1])->default(0)->comment('0-Yes, 1-No');
            $table->enum('SourceOfDocument', [0, 1, 2, 3])->default(0)->comment('0-N/A, 1-हार्डकपी, 2-एनएनएसडब्लु, 3-कार्यालयको अभिलेख');
            $table->string('Remarks', 200)->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('ChecklistID')->references('id')->on('checklists')->onDelete('cascade');
            $table->foreign('ChecklistItemID')->references('id')->on('checklist_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_details');
    }
};
