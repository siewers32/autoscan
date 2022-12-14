<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdw', function (Blueprint $table) {
            $table->id();
            $table->string('kenteken');
            $table->string('voertuigsoort');
            $table->string('merk');            
            $table->string('model');            
            $table->string('brandstof');            
            $table->string('kleur');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rdw');
    }
};
