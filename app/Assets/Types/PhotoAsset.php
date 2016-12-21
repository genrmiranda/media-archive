<?php 

namespace App\Assets\Types;

use App\Assets\Types\PhotoAssetInterface;


class PhotoAsset implements PhotoAssetInterface
{

  const DEFAULT_ASSET_TYPE = 'photos';
  const DEFAULT_ASSET_SIZES = '300,800';
  const DEFAULT_OUTPUT_JSON_DOC = 0;
  const DEFAULT_S3_UPLOAD = 0;
  
  protected $type;
  protected $sizes;
  protected $output_Json_doc;
  protected $s3_upload;

  public function __construct() 
  {
    $this->type = self::DEFAULT_ASSET_TYPE;
    $this->sizes =  explode(',',self::DEFAULT_ASSET_SIZES);
    $this->output_Json_doc = self::DEFAULT_OUTPUT_JSON_DOC;
    $this->s3_upload = self::DEFAULT_S3_UPLOAD;
  }
  
  public function setType($type) {
    $this->type = $type;
  }
 
  public function setOutputJsonDoc($output_Json_doc) {
    if ($output_Json_doc=='false') $this->output_Json_doc = 0;
    if ($output_Json_doc=='true') $this->output_Json_doc = 1;
  } 
  
  public function setS3Upload($s3_upload) {
    if ($s3_upload=='false') $this->s3_upload = 0;
    if ($s3_upload=='true') $this->s3_upload = 1;
  }  
  
  public function setSizes($sizes) {
    $this->sizes = explode(',',$sizes);
    sort($this->sizes);
  }  
  
  public function getType() {
    return $this->type;
  }
 
  public function getOutputJsonDoc() {
    return $this->output_Json_doc;
  }  
  
  public function getS3Upload() {
    return $this->s3_upload;
  }   
  
  public function getSizes() {
    return $this->sizes;
  }   
    
}