<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [ 'mobile' , 'address' , 'email' , 'instagram' , 'whatsUp' , 'telegram' , 'aboutUs'];
}
