<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

   protected $fillable = ['tag_name', 'tag_code'];
   
    protected $hidden = ['id', 'pivot','created_at','updated_at'];

    /**
    * Get all of the Assets for each tag.
    */
    public function assets() 
    {
      return $this->belongsToMany(Asset::class);
    }  

}
