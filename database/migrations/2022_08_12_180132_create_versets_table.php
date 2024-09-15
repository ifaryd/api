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
            $table->integer("numero");
            $table->longText("contenu");
            $table->longText("info")->nullable();
            $table->longText("linkAtContent")->nullable()->comment("les textes qui ont un lien");
            $table->longText("urlContent")->comment("le lien associé au texte");
            $table->foreignId('predication_id')->nullable()->constrained('predications')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('versets');
    }
};
