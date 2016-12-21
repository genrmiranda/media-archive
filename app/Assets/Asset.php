<?php namespace App\Assets;

use App\Asset as AssetModel;
use App\Assets\AssetHelper;
use App\Assets\AssetDirectory;

class Asset
{
  use AssetHelper, AssetDirectory;    
   
  protected $type;  
  protected $sizes;  
  protected $output_Json_doc;  
  protected $s3_upload;  
  
  protected function validateAssetChecksum($asset_path, $regenerate=false) {
    $file_checksum = sha1_file($asset_path);
    $Asset = AssetModel::where('file_checksum',$file_checksum)->get(); 
    if (!$Asset->isEmpty()) {
      if ($regenerate) $this->deleteAsset($Asset[0]->id);
      return true;
    } 
    return false;
  }   
  
  protected function deleteAsset($asset_id) {
    $Asset = AssetModel::find($asset_id);
    $Asset->delete();
  }    
  
}