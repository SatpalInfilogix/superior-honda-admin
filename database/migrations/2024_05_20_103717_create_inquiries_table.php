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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date')->nullable();
            $table->string('mileage')->nullable();
            $table->string('vehicle')->nullable();
            $table->string('year')->nullable();
            $table->string('lic_no')->nullable();
            $table->string('address')->nullable();
            $table->string('returning')->nullable();
            $table->string('color')->nullable();
            $table->string('tel_digicel')->nullable();
            $table->string('tel_lime')->nullable();
            $table->string('dob')->nullable();
            $table->string('chassis')->nullable();
            $table->string('engine')->nullable();
            $table->json('conditions')->nullable();
            $table->string('sign')->nullable();
            $table->date('sign_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
