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
        Schema::create('pet_forms', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); 
            $table->string('photo');
            $table->string('chipset');
            $table->bigInteger('check_id');
            $table->string('pet_name');
            $table->string('pet_type');
            $table->string('pet_family_type');
            $table->string('pet_region');
            $table->string('pet_country');
            $table->string('pet_city');
            $table->boolean('pet_street');
            $table->string('iin');
            $table->string('reg_date');
            $table->integer('gr');
            $table->integer('mm');
            $table->integer('old_year');
            $table->integer('old_month');
            $table->string('comment');
            $table->string('other_comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_forms');
    }
};
