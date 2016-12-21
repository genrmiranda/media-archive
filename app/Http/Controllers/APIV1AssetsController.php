<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Asset;
use App\Type;

class APIV1AssetsController extends Controller
{

    use APIHttpHandler;
      
    protected $type;   
    protected $plusminus = 10;
    protected $limit = 25;
   
    public function __construct(Request $request) 
    {
      $this->type  = $request->type;
      if ($request->limit)     $this->limit = $request->limit;
      if ($request->plusminus) $this->plusminus = $request->plusminus;
    }   

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
       $Asset = Asset::where('id', $request->id)->with('type','category','details','sizes','tags','colors')->get();
       return Self::httpResponse($Asset);
    }


    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function items(Request $request)
    {
       $Type  = Type::where('type_code',$this->type)->get();     
       $Assets = Asset::where('type_id',$Type[0]->id)->with('type','category','details','sizes','tags','colors')->paginate($this->limit);
       return Self::httpResponse($Assets);
    }


    /**
     * Display the specified resources.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchKeyword(Request $request)
    {
      $keywords = array( (string) $request->keyword );
      $Type  = Type::where('type_code',$this->type)->get(); 
      $Assets = Asset::where('type_id',$Type[0]->id)
                     ->whereHas('tags', function($query) use($keywords) {
                          $query->whereIn('tag_name', $keywords);
                       })
                     ->with('type','category','details','sizes','tags','colors')
                     ->paginate($this->limit);
      
      return Self::httpResponse($Assets);
    }
    
    
    /**
     * Display the specified resources.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function searchColor(Request $request)
    {
      
      if ( empty($request->hex) && empty($request->rgb) && empty($request->hsl) ) {
        return Self::httpResponse([]);
      }

      if ($request->hex) {
         $HSL = self::HEX2HSL($request->hex); 
         $h   = (int) $HSL['h'];
         $s   = (int) $HSL['s'];
         $l   = (int) $HSL['l'];
      }
      if ($request->rgb) {
         list($r, $g, $b) = explode('.',$request->rgb); 
         $HSL = self::RGB2HSL($r, $g, $b, true); 
         $h   = (int) $HSL['h'];
         $s   = (int) $HSL['s'];
         $l   = (int) $HSL['l'];        
      }
      if ($request->hsl) {
         list($h, $s, $l) = explode('.',$request->hsl); 
      }            
      
      $color = [ 'h' => $h, 's' => $s, 'l' => $l ];
      
      $Type = Type::where('type_code',$this->type)->get(); 
      
      $Assets = Asset::where('type_id',$Type[0]->id)
                     ->whereHas('colors', function($query) use($color) {                  
                          $hsl  = [ max($color['h']-$this->plusminus,0) , max($color['s']-$this->plusminus,0) , max($color['l']-$this->plusminus,0) ];
                          $hsl2 = [ min($color['h']+$this->plusminus,360) , min($color['s']+$this->plusminus,100) , min($color['l']+$this->plusminus,100) ];                          
                          $query->whereBetween('hue', [$hsl[0], $hsl2[0] ]);                    
                          $query->whereBetween('sat', [$hsl[1], $hsl2[1] ]);
                          $query->whereBetween('lum', [$hsl[2], $hsl2[2] ]);
                          $query->orderBy('count', 'desc');
                       })
                     ->with('type','category','details','sizes','tags','colors')
                     ->paginate($this->limit);
      return Self::httpResponse($Assets);
    }    

}