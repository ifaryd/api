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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string("titre");
            $table->longText("url");
            $table->string("lieu")->nullable();
            $table->longText("description")->nullable();
            $table->foreignId('type_id')->nullable()->constrained('types')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('videos');
    }
};
