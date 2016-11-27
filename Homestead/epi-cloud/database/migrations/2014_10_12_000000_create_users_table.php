<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        $user = new User();
        $user->first_name = "Luc";
        $user->last_name = "Barriol";
        $user->email = "luc.barriol@gmail.com";
        $user->password = bcrypt("luc_b");
        $user->save();

        $user = new User();
        $user->first_name = "Eric";
        $user->last_name = "Menut";
        $user->email = "eric.menut@gmail.com";
        $user->password = bcrypt("eric_m");
        $user->save();

        $user = new User();
        $user->first_name = "Laurence";
        $user->last_name = "Walbaum";
        $user->email = "laurence.walbaum@gmail.com";
        $user->password = bcrypt("laurence_w");
        $user->save();

        $user = new User();
        $user->first_name = "Daniel";
        $user->last_name = "Beloudini";
        $user->email = "daniel.beloudini@gmail.com";
        $user->password = bcrypt("daniel_b");
        $user->save();

        $user = new User();
        $user->first_name = "Guy";
        $user->last_name = "Cornaz";
        $user->email = "guy.cornaz@gmail.com";
        $user->password = bcrypt("guy_c");
        $user->save();

        $user = new User();
        $user->first_name = "Agnes";
        $user->last_name = "Teyssier";
        $user->email = "agnes.teyssier@gmail.com";
        $user->password = bcrypt("agnes_t");
        $user->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
