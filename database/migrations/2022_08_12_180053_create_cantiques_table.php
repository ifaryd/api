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
        Schema::create('cantiques', function (Blueprint $table) {
            $table->id();
            $table->string("titre");
            $table->longText("lien_audio");
            $table->longText("nom_fichier")->nullable();
            $table->longText("contenu")->nullable();
            $table->integer("duree")->nullable();
            $table->foreignId('langue_id')->nullable()->constrained('langues')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('cantiques');
    }
};
