<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $hidden = ['id','created_at','updated_at'];
  
    /**
    * Get all of the Asset for each type.
    */
    public function assets() 
    {
      return $this->hasMany(Asset::class);
    }  
    
}
