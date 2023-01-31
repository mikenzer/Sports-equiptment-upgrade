<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin_roles extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
        'admin_admin_id', 'roles_id_roles'
    ];
    protected $primaryKey = 'id_admin_roles';
    protected $table = 'admin_roles';
}
