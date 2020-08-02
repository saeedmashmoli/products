<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productview extends Model
{
    protected $fillable = [ 'ip' , 'product_id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
