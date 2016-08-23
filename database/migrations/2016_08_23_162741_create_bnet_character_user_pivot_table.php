<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattleNetCharacterUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battle_net_characters_user', function (Blueprint $table) {
            // bnet_ instead of battle_net because otherwize it'd generate too long names for IDX
            $table->integer('bnet_character_id')->unsigned()->index();
            $table->foreign('bnet_character_id')->references('id')->on('battle_net_characters')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['bnet_character_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('battle_net_characters_user');
    }
}
