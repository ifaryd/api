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
            $table->integer("numero");
            $table->longText("lien_audio")->nullable();;
            $table->string("nom_audio")->nullable();;
            $table->longText("lien_video")->nullable();
            $table->integer("duree")->nullable();
            $table->string("chapitre")->nullable();
            $table->longText("couverture")->nullable();
            $table->longText("sermon_similaire")->nullable();
            $table->foreignId('langue_id')->nullable()->constrained('langues')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('predications');
    }
};
