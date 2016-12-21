<?php

namespace App\Assets\Types;


interface PhotoAssetInterface
{
 
  public function setType($type);
 
  public function setOutputJsonDoc($output_Json_doc);
  
  public function setS3Upload($s3_upload);
  
  public function setSizes($sizes);
  
  public function getType();
 
  public function getOutputJsonDoc();
  
  public function getS3Upload();
  
  public function getSizes();
    
}