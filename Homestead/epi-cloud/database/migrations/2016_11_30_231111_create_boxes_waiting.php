<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxesWaiting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes_waiting', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("user_id");
            $table->string("name");
            $table->string("os");
            $table->string("os_version");
            $table->integer("ram");
            $table->integer("nb_core");
            $table->boolean("running")->default(false);
            $table->string("ip")->nullable();
            $table->string("port")->nullable();
            $table->string("status");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boxes_waiting');
    }
}
