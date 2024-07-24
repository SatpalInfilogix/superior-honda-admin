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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id');
            $table->string('name');
            $table->date('date')->nullable();
            $table->string('email')->nullable();
            $table->string('mileage')->nullable();
            $table->string('vehicle')->nullable();
            $table->string('year')->nullable();
            $table->string('licence_no')->nullable();
            $table->string('address')->nullable();
            $table->string('returning')->nullable();
            $table->string('color')->nullable();
            $table->string('tel_digicel')->nullable();
            $table->string('tel_lime')->nullable();
            $table->string('dob')->nullable();
            $table->string('chassis')->nullable();
            $table->string('engine')->nullable();
            $table->text('conditions')->nullable();
            $table->text('sign')->nullable();
            $table->date('sign_date')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status',['Pending', 'In Progress','Completed'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
