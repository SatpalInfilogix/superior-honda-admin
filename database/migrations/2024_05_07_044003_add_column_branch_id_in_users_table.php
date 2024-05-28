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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('phone_digicel')->nullable();
            $table->string('phone_lime')->nullable();
            $table->string('address')->nullable();
            $table->string('info')->nullable();
            $table->string('city')->nullable();
            $table->string('company_info')->nullable();
            $table->string('licence_no')->nullable();
            $table->string('cus_code')->nullable();

            $table->foreign('branch_id')->references('id')->on('branches');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['branch_id', 'phone_digicel', 'phone_lime', 'licence_no', 'address', 'cus_code', 'info', 'company_info', 'city']);
        });
    }
};
