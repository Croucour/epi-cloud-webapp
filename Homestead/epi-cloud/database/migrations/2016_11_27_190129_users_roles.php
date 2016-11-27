<?php


use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin = Role::where('name', '=', 'SysAdmin')->first();

        $user = User::where('last_name', '=', 'Barriol')->first();
        $user->attachRole($admin);

        $employees = Role::where('name', '=', 'Employees')->first();

        $user = User::where('last_name', '=', 'Menut')->first();
        $user->attachRole($employees);

        $user = User::where('last_name', '=', 'Walbaum')->first();
        $user->attachRole($employees);

        $student = Role::where('name', '=', 'Student')->first();

        $user = User::where('last_name', '=', 'Beloudini')->first();
        $user->attachRole($student);

        $user = User::where('last_name', '=', 'Cornaz')->first();
        $user->attachRole($student);

        $user = User::where('last_name', '=', 'Teyssier')->first();
        $user->attachRole($student);

        $createPost = new Permission();
        $createPost->name         = 'create-post';
        $createPost->display_name = 'Create Posts'; // optional

        $createPost->description  = 'create new blog posts'; // optional
        $createPost->save();

        $admin->attachPermission($createPost);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
