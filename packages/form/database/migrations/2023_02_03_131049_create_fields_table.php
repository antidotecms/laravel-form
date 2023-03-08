<?php

use Antidote\LaravelForm\Models\Form;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('field_type');
            $table->json('field_attributes')->nullable();

            $table->foreignIdFor(Form::class);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fields');
    }
};