<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('realm');
            $table->string('battlegroup');
            $table->string('class');
            $table->string('race');
            $table->string('gender');
            $table->string('thumbnail')->default("http://wow.zamimg.com/uploads/screenshots/normal/303438-capn-placeholder.jpg");
            $table->string('guild')->default('');
            $table->string('guildRealm')->default('');
            $table->integer('level');
            $table->integer('achievementPoints');
            $table->timestamp('lastModified');
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
        Schema::drop('characters');
    }
}
