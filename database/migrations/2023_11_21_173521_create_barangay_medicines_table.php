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
        Schema::create('barangay_medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barangay_id');
            $table->unsignedBigInteger('medicine_id');
            $table->string('generic_name');
            $table->string('brand_name');
            $table->string('category');
            $table->decimal('price', 10, 2);
            $table->date('expiration_date');
            $table->integer('stocks');
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
            $table->text('admin_comment')->nullable();
            $table->integer('expected_stocks')->nullable();
            $table->date('distribution_schedule')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('barangay_id')->references('id')->on('barangays')->onDelete('cascade');
            $table->foreign('medicine_id')->references('id')->on('medicines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangay_medicines');
    }
};
