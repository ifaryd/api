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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->string("libelle");
            $table->string("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('charge_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('charge_id')->constrained('charges')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pays_id')->nullable()->constrained('pays')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('assemblee_id')->nullable()->constrained('assemblees')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('principal', false)->comment("Celui qui occupe la charge principal est celui dont le numero s'affichera pour l'assemblée.");
            $table->integer("position_chantre")->nullable()->comment("Si la charge est chantre il faut preciser l'ordre d'affichage");
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
        Schema::dropIfExists('charge_user');
        Schema::dropIfExists('charges');
    }
};
