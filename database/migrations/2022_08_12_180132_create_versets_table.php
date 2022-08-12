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
        Schema::create('versets', function (Blueprint $table) {
            $table->id();
            $table->integer("numero")->nullable();
            $table->string("contenu")->nullable();
            $table->string("info")->nullable();
            $table->foreignId('predication_id')->nullable()->constrained('predications')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('versets');
    }
};
