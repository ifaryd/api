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
        Schema::create('assemblees', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->foreignId('ville_id')->constrained('villes')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('localisation')->nullable();
            $table->longText('addresse')->nullable();
            $table->longText('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assemblees');
    }
};
