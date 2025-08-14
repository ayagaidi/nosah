<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_diet_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('meal_type');
            $table->string('food_category');
            $table->string('food_item');
            $table->string('portion_size')->nullable();
            $table->integer('calories')->nullable();
            $table->float('carbs', 8, 2)->nullable();
            $table->float('protein', 8, 2)->nullable();
            $table->float('fat', 8, 2)->nullable();
            $table->float('fiber', 8, 2)->nullable();
            $table->string('fluid_intake')->nullable();
            $table->string('supplements')->nullable();
            $table->text('special_instructions')->nullable();
            $table->text('dietary_restrictions')->nullable();
            $table->text('compliance_notes')->nullable();
            $table->unsignedInteger('prescribed_by')->nullable();
            $table->date('date_prescribed')->nullable();
            $table->timestamps();
            $table->unsignedInteger('patient_id');

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            // يمكنك إضافة foreign للطبيب إذا كان لديك جدول doctors
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_diet_plans');
    }
};
