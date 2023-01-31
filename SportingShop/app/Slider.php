<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'slider_name', 'slider_img', 'slider_status', 'slider_des'
    ];
    protected $primaryKey = 'slider_id';
    protected $table = 'tbl_slider';
}
