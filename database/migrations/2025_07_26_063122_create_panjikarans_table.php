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
        Schema::create('panjikarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ChecklistID');
            $table->string('CommonNameOfPesticide', 200)->nullable();
            $table->string('ChemicalName', 200);
            $table->text('IUPAC_Name')->nullable();
            $table->string('Cas_No', 20)->nullable();
            $table->string('Atomic_Formula', 100)->nullable();
            $table->unsignedBigInteger('SourceID');
            $table->unsignedBigInteger('ObjectiveID');
            $table->unsignedBigInteger('UsageID');
            $table->string('DapperQuantity', 255)->nullable();
            $table->unsignedBigInteger('DQUnitID');
            $table->string('Waiting_duration', 255)->nullable();
            $table->string('FirstAid', 255)->nullable();
            $table->unsignedBigInteger('PackageDestroyID');
            $table->string('Foreign_producer_company_name', 255)->nullable();
            $table->string('Foreign_producer_company_address', 255)->nullable();
            $table->string('Nepali_producer_company_name', 255)->nullable();
            $table->string('Nepali_producer_company_address', 255)->nullable();
            $table->string('Nepali_producer_company_email', 100)->nullable();
            $table->string('Nepali_producer_company_contact', 100)->nullable();
            $table->string('Samejasamcompany_s_detail_name', 255)->nullable();
            $table->string('Samejasamcompany_s_detail_address', 255)->nullable();
            $table->string('Samejasamcompany_s_detail_email', 100)->nullable();
            $table->string('Samejasamcompany_s_detail_contact', 100)->nullable();
            $table->string('Packing_company_details_name', 255)->nullable();
            $table->string('Packing_company_details_address', 255)->nullable();
            $table->string('Packing_company_details_email', 100)->nullable();
            $table->string('Packing_company_details_contact', 100)->nullable();
            $table->string('Paitharkarta_company_details_name', 255)->nullable();
            $table->string('Paitharkarta_company_details_address', 255)->nullable();
            $table->string('Paitharkarta_company_details_email', 100)->nullable();
            $table->string('Paitharkarta_company_details_contact', 100)->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('ChecklistID')->references('id')->on('checklists')->onDelete('cascade');
            $table->foreign('SourceID')->references('id')->on('sources')->onDelete('cascade');
            $table->foreign('ObjectiveID')->references('id')->on('objectives')->onDelete('cascade');
            $table->foreign('UsageID')->references('id')->on('usages')->onDelete('cascade');
            $table->foreign('DQUnitID')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('PackageDestroyID')->references('id')->on('package_destroys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panjikarans');
    }
};
