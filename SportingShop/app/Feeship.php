<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\City;
use App\Province;
use App\Wards;
class Feeship extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'fee_matp', 'fee_maqh', 'fee_maxa', 'fee_feeship'
    ];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_fee_ship';
    public function city(){
        return $this->belongsTo('App\City','fee_matp');
    }
    public function province(){
        return $this->belongsTo('App\Province','fee_maqh');
    }
    public function wards(){
        return $this->belongsTo('App\Wards','fee_maxa');
    }
}
