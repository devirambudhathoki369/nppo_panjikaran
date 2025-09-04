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
        Schema::create('common_names', function (Blueprint $table) {
            $table->id();
            $table->string('common_name');
            $table->string('rasayanik_name')->nullable();
            $table->string('iupac_name')->nullable();
            $table->string('cas_no')->nullable();
            $table->string('molecular_formula')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_names');
    }
};
