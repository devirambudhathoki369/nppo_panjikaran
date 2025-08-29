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
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->string('PanjikaranDecisionDate', 10)->nullable();
            $table->string('PanjikaranDecisionNo', 20)->nullable();
            $table->string('ImporterName', 200);
            $table->string('LicenseNo', 20);
            $table->enum('ApplicationType', [0, 1])->comment('0-Importer, 1-Producer/Formulator/Packaging');
            $table->string('TradeNameOfPesticide', 255)->nullable();

            $table->string('NameofProducer', 255)->nullable();
            $table->string('Address', 255)->nullable();
            $table->unsignedBigInteger('CountryID')->nullable();
            $table->foreign('CountryID')->nullable()->references('id')->on('Countries');
            $table->string('ProducerCountryPanjikaranNo', 255)->nullable();

            $table->enum('Status', [0, 1, 2])->default(0)->comment('0-initially Entered, 1-Verified, 2-Approved');

            $table->string('DateOfReceiptInNNSWNep', 12)->nullable();
            $table->string('ContainerReceiptDate', 12)->nullable();


            $table->unsignedBigInteger('CreatedBy')->nullable();
            $table->date('CreatedDate')->nullable();
            $table->unsignedBigInteger('VerifiedBY')->nullable();
            $table->date('VerifiedDate')->nullable();
            $table->unsignedBigInteger('ApprovedBy')->nullable();
            $table->date('ApprovedDate')->nullable();
            $table->foreignId('formulation_id')->nullable()->constrained('formulations')->onDelete('set null');
            $table->foreignId('bishadi_type_id')->nullable()->constrained('bishadi_types')->onDelete('set null');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('CreatedBy')->references('id')->on('users');
            $table->foreign('VerifiedBY')->references('id')->on('users');
            $table->foreign('ApprovedBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklists');
    }
};
