<?php

use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Roles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin = Role::where('name', '=', 'SysAdmin')->first();

        if ($admin == null) {
            $admin = new Role();
            $admin->name = 'SysAdmin';
            $admin->save();

            $employees = new Role();
            $employees->name = 'Employees';
            $employees->save();

            $student = new Role();
            $student->name = 'Students';
            $student->save();

            $student = new Role();
            $student->name = 'Student';
            $student->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
