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
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->string("sigle");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('langue_pays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('langue_id')->constrained('langues')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pays_id')->constrained('pays')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('principal', false);
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
        Schema::dropIfExists('langue_pays');
        Schema::dropIfExists('pays');
    }
};
