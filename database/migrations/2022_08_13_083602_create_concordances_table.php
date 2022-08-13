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
        Schema::create('concordances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verset_from_id')->constrained('versets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('verset_to_id')->constrained('versets')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('concordances');
    }
};
