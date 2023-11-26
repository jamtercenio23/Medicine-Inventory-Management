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
        Schema::table('barangay_medicines', function (Blueprint $table) {
            $table->timestamp('requested_at')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('barangay_medicines', function (Blueprint $table) {
            $table->dropColumn('requested_at');
        });
    }
};
