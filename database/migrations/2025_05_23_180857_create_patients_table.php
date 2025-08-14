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
        Schema::dropIfExists('patients'); // Ensure table is dropped before creating (for refresh)
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctors_id')->unsigned()->nullable();
            $table->foreign('doctors_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->string('patient_number')->unique();
            $table->string('full_name');
            $table->string('email')->nullable();
                        $table->string('password');

            $table->date('dob');
            $table->enum('gender', ['M', 'F']);
            $table->text('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('allergies')->nullable();
            $table->text('medications')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
