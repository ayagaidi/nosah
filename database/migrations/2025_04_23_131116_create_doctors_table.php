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
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname',50);
            $table->string('username',50)->unique();
            $table->string('email',100)->unique();
            $table->string('phonenumber',10)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->default(1); // Field for status
            $table->string('image')->nullable(); // Add image field
            $table->string('cv')->nullable(); // Add CV field
            $table->timestamp('created_at')->useCurrent();
            $table->rememberToken();
            $table->integer('specializations_id')->unsigned()->nullable(); // Rename field for consistency
            $table->foreign('specializations_id')->references('id')->on('specializations')->onDelete('cascade'); // Update foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
