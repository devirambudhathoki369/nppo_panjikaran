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
        Schema::create('nnsw_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checklist_id');
            $table->unsignedBigInteger('panjikaran_id');
            $table->string('nepal_rastriya_ekdwar_pranalima_anurodh_no')->nullable();
            $table->date('nepal_rastriya_ekdwar_pranalima_anurodh_date')->nullable();
            $table->string('company_code')->nullable();
            $table->string('swikrit_no')->nullable();
            $table->date('swikrit_date')->nullable();
            $table->string('baidata_abadhi')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
            $table->foreign('panjikaran_id')->references('id')->on('panjikarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nnsw_details');
    }
};
