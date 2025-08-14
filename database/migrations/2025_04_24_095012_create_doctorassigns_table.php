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
        Schema::create('doctorassigns', function (Blueprint $table) {
            $table->increments('id');
         
            $table->boolean('active')->default(1); // Field for status
            $table->timestamp('created_at')->useCurrent();
            $table->integer('doctors_id')->unsigned()->nullable(); // Rename field for consistency
            $table->foreign('doctors_id')->references('id')->on('doctors')->onDelete('cascade'); // Update foreign key

            $table->integer('clinics_id')->unsigned()->nullable(); // Rename field for consistency
            $table->foreign('clinics_id')->references('id')->on('clinics')->onDelete('cascade'); // Update foreign key

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctorassigns');
    }
};
