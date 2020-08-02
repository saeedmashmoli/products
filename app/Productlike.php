<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productlike extends Model
{
    protected $fillable = [ 'ip' , 'product_id' , 'like'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
