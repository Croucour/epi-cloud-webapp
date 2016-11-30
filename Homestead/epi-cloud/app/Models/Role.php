<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $name;
    protected $display_name;
    protected $description;
}