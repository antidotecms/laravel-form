<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->json('to');
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form');
    }
};