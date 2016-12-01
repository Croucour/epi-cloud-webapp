<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $name;
    protected $display_name;
    protected $description;

    public static function detachAllRoles($user_id)
    {
        DB::table('role_user')->where('user_id', $user_id)->delete();

    }
}