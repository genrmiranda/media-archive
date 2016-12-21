<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetColor extends Model
{
  
    protected $fillable = ['red', 'green', 'blue', 'hue', 'sat', 'lum', 'count'];
    
    protected $hidden = ['id', 'asset_id'];
   
    public $timestamps = false; 
     
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
      protected $casts = [
          'red' => 'int',
          'green' => 'int',
          'blue' => 'int',
          'hue' => 'int',  
          'sat' => 'int',   
          'lum' => 'int',    
          'count' => 'int'  
      ];      
    
}
