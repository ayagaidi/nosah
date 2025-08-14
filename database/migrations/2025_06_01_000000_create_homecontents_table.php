<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homecontents', function (Blueprint $table) {
            $table->id();
            $table->string('clinics_title')->nullable();
            $table->text('clinics_text')->nullable();
            $table->string('inbody_title')->nullable();
            $table->text('inbody_text')->nullable();
            $table->string('banner_title')->nullable();
            $table->text('banner_text')->nullable();
            $table->string('video_url')->nullable(); // add video field
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homecontents');
    }
};
