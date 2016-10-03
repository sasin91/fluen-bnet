<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterSpecCharacterPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_spec_character', function (Blueprint $table) {
            $table->integer('character_spec_id')->unsigned()->index();
            $table->foreign('character_spec_id')->references('id')->on('character_specs')->onDelete('cascade');
            $table->integer('character_id')->unsigned()->index();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->primary(['character_spec_id', 'character_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('character_spec_character');
    }
}
