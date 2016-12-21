<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetDetail extends Model
{
  
    protected $fillable = ['camera', 'aperture', 'color_space', 'exposure', 'iso', 'focal_length', 'height', 'width', 'resolution', 'orientation', 'software', 'file_size', 'creation_date'];
    
    public $timestamps = false;
    
    protected $hidden = ['id', 'asset_id'];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
      protected $casts = [
          'color_space' => 'int',
          'focal_length' => 'int',
          'height' => 'int',
          'width' => 'int',  
          'resolution' => 'int',   
          'orientation' => 'int',    
          'file_size' => 'int'
      ];      
      
     /**
     * Get the Cart that owns OrderProduct.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }       
    
}
