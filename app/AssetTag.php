<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetTag extends Model
{
    public $timestamps = false;
    
     protected $hidden = ['id', 'asset_id'];
}
