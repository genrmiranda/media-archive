<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $hidden = ['id','created_at','updated_at'];
    
    /**
    * Get all of the Assets for each Category.
    */
    public function assets() 
    {
      return $this->hasMany(Asset::class);
    }    
        
}
