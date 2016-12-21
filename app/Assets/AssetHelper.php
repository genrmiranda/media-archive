<?php 

namespace App\Assets;

trait AssetHelper
{

  /**
   * Generate stopwords array.
   *
   * @return array
   */
    public function StopwordsArray()
    {
      return array('a', 'an', 'al', 'the', 'and', 'or', 'with', 'to', 'of', 'for', 'in', 'on', 'at', 'as', 'by');
    }
 
  /**
   * Generate extract file
   *
   * @return string
   */  
    public function extractFilename($filename_path, $toArray=true) {
      $path_parts = pathinfo($filename_path);
      if (!$toArray) return $path_parts['filename'] . '.' . $path_parts['extension'];
      return $path_parts;
    }     
    
  /**
   * reverse str_slug to title case
   *
   * @return string
   */  
    public function reverse_str_slug($text) {
      $text = str_slug($text, '-');
      $text = str_replace('-', " ", $text);
      $text = ucwords( strtolower($text) );
      return $text;
    }      
    

  /**
   * Return base folder name
   *
   * @return string
   */  
    public function getBasefolder($path) {
      $path_array = explode( (string) DIRECTORY_SEPARATOR, $path);
      return $path_array[count($path_array)-1];
    }    
    
 
   /**
   * Return base folder name
   *
   * @return string
   */  
    public function getPublicUrls($asset_id, $type, $height, $width, $dir_hash, $asset_filename) {    
      $s3_path = $type . DIRECTORY_SEPARATOR . $dir_hash . DIRECTORY_SEPARATOR . str_pad($asset_id, 10, "0", STR_PAD_LEFT) . DIRECTORY_SEPARATOR .  $width . DIRECTORY_SEPARATOR . $asset_filename;
      $asset_url = env('ASSET_DOMAIN') . DIRECTORY_SEPARATOR . $s3_path; 
      $cdn_url = env('CDN_DOMAIN') . DIRECTORY_SEPARATOR . $s3_path;   
      $file_path = public_path() . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $s3_path;     
      return compact("asset_url", "cdn_url", "s3_path", "file_path");     
    } 
 
 
   /**
   * convert RGB to HSL Color
   *
   * @return array
   */      
    public static function RGB2HSL( $r, $g, $b, $in_percent = false ) {
      $oldR = $r;
      $oldG = $g;
      $oldB = $b;
    
      $r /= 255;
      $g /= 255;
      $b /= 255;
    
        $max = max( $r, $g, $b );
      $min = min( $r, $g, $b );
    
      $h;
      $s;
      $l = ( $max + $min ) / 2;
      $d = $max - $min;
    
          if( $d == 0 ){
              $h = $s = 0; // achromatic
          } else {
              $s = $d / ( 1 - abs( 2 * $l - 1 ) );
    
        switch( $max ){
                  case $r:
                    $h = 60 * fmod( ( ( $g - $b ) / $d ), 6 ); 
                            if ($b > $g) {
                          $h += 360;
                      }
                      break;
    
                  case $g: 
                    $h = 60 * ( ( $b - $r ) / $d + 2 ); 
                    break;
    
                  case $b: 
                    $h = 60 * ( ( $r - $g ) / $d + 4 ); 
                    break;
              }                       
      }
    
      if ($in_percent) $h = intval($h);
      if ($in_percent) $s = intval($s*100);
      if ($in_percent) $l = intval($l*100);
    
      return array( 'h' => round( $h, 2 ), 's' => round( $s, 2 ), 'l' => round( $l, 2 ) );
    }     
 
 
   /**
   * convert HSL to RGB  Color
   *
   * @return array
   */  
  public static function HSL2RGB( $h, $s, $l ){
          
     $r; $g; $b;
    
      $c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
      $x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
      $m = $l - ( $c / 2 );
    
      if ( $h < 60 ) {
        $r = $c;
        $g = $x;
        $b = 0;
      } else if ( $h < 120 ) {
        $r = $x;
        $g = $c;
        $b = 0;     
      } else if ( $h < 180 ) {
        $r = 0;
        $g = $c;
        $b = $x;          
      } else if ( $h < 240 ) {
        $r = 0;
        $g = $x;
        $b = $c;
      } else if ( $h < 300 ) {
        $r = $x;
        $g = 0;
        $b = $c;
      } else {
        $r = $c;
        $g = 0;
        $b = $x;
      }
    
      $r = ( $r + $m ) * 255;
      $g = ( $g + $m ) * 255;
      $b = ( $b + $m  ) * 255;
    
        return array( 'r' => floor( $r ), 'g' => floor( $g ), 'b' => floor( $b ) );
    }  
    

   /**
   * convert reorder multidimensional arrays
   *
   * @return array
   */ 
    public function array_orderby($data)
      {
          $args = func_get_args();
          $data = array_shift($args);
          foreach ($args as $n => $field) {
              if (is_string($field)) {
                  $tmp = array();
                  foreach ($data as $key => $row)
                      $tmp[$key] = $row[$field];
                  $args[$n] = $tmp;
                  }
          }
          $args[] = &$data;
          call_user_func_array('array_multisort', $args);
          return array_pop($args);
      }
  
}