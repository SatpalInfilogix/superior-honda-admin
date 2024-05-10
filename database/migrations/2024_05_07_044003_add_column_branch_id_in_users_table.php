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
            $table->integer('phone_Digicel')->nullable();
            $table->integer('phone_Lime')->nullable();
            $table->string('lic_no')->nullable();
            $table->string('address')->nullable();
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
            $table->dropColumn(['branch_id', 'phone_Digicel', 'phone_Lime', 'lic_no', 'address', 'cus_code']);
        });
    }
};
