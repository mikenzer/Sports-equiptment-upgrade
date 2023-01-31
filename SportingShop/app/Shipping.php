<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'shipping_address', 'shipping_note', 'shipping_pmethod'
    ];
    protected $primaryKey = 'shipping_id';
    protected $table = 'tbl_shipping';
}


