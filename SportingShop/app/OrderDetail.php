<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'order_code', 'product_id', 'product_name', 'product_price', 'product_quantity', 'product_coupon', 'product_feeship'
    ];
    protected $primaryKey = 'order_detail_id';
    protected $table = 'tbl_order_details';
    public function product(){
        return $this->belongsTo('App\Product', 'product_id');
    }
}
