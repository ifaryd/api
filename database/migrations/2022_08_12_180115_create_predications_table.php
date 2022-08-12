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
        Schema::create('predications', function (Blueprint $table) {
            $table->id();
            $table->string("titre");
            $table->string("sous_titre")->nullable();
            $table->string("lien_audio")->nullable();
            $table->string("nom_audio")->nullable();
            $table->string("lien_video")->nullable();
            $table->integer("duree")->nullable();
            $table->integer("numero");
            $table->integer("chapitre")->nullable();
            $table->string("couverture")->nullable();
            $table->string("sermon_similaire")->nullable();
            $table->foreignId('langue_id')->nullable()->constrained('langues')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('predications');
    }
};
