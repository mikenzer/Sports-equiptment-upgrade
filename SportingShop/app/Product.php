<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_name', 'product_keywords', 'category_id', 'brand_id', 'product_price', 'product_des', 'product_content', 'product_img', 'product_status'
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';
}
