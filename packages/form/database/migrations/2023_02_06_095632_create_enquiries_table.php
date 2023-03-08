<?php

use Antidote\LaravelForm\Models\Form;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();

            $table->json('data');
            $table->foreignIdFor(Form::class);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enquiries');
    }
};