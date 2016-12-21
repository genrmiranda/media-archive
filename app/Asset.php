<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
  
     protected $fillable = ['title', 'caption', 'author', 'file_checksum', 'mime_type'];     
     
     protected $hidden = ['type_id','category_id','file_checksum'];
     
     /**
     * Get the Details asssociated with the Asset.
     */
    public function details()
    {
        return $this->hasOne(AssetDetail::class);
    }     

    /**
    * Get all of the Colors for the Asset.
    */
    public function sizes() 
    {
      return $this->hasMany(AssetSize::class);
    }  

    /**
    * Get all of the Colors for the Asset.
    */
    public function colors() 
    {
      return $this->hasMany(AssetColor::class);
    }     
    
     /**
     * Get the Tags asssociated with the Asset.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }      
    
     /**
     * Get the Category that owns the Asset.
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }         
    
     /**
     * Get the Category that owns the Asset.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }     
    
}
