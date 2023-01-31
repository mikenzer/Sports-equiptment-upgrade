<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'tenxa', 'type', 'maqh'
    ];
    protected $primaryKey = 'maxa';
    protected $table = 'tbl_xaphuongthitran';
}
