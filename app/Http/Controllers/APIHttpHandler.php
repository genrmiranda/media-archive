<?php 

namespace App\Http\Controllers;

trait APIHttpHandler
{
  
  /**
  * convert array to json http response
  *
  * @return json
  */    
  public static function httpResponse($results) 
  { 
       if ( count($results) ) {
          return $results;
       }  
       else {
         return response()->json(['error' => 404, 'status' => 'not found'], 404);       
       }  
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
    
    if ($in_percent) array( 'h' => $h, 's' => $s, 'l' => $l );
  
    return array( 'h' => round( $h, 2 ), 's' => round( $s, 2 ), 'l' => round( $l, 2 ) );
  }     

  /**
   * convert HEX to RGB  Color
   *
   * @return array
  */  
  public static function HEX2HSL($hex) { 
    $hex = "#"+$hex;
    list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");  
    return self::RGB2HSL( $r, $g, $b, true);
  }     
  
}

