<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('barangay_distributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangay_id')->nullable();
            $table->unsignedBigInteger('barangay_patient_id');
            $table->unsignedBigInteger('barangay_medicine_id');
            $table->integer('stocks');
            $table->date('checkup_date');
            $table->text('diagnose');
            $table->unsignedBigInteger('bhw_id')->nullable();
            $table->foreign('bhw_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('barangay_id')->references('id')->on('barangays')->onDelete('cascade');
            $table->foreign('barangay_patient_id')->references('id')->on('barangay_patients')->onDelete('cascade');
            $table->foreign('barangay_medicine_id')->references('id')->on('barangay_medicines')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangay_distributions');
    }
};
