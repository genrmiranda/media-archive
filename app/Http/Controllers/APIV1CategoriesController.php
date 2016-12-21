<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Asset;
use App\Type;
use App\Category;

class APIV1CategoriesController extends Controller
{
  
    use APIHttpHandler;
      
    protected $type;   
    protected $limit = 25;
   
    public function __construct(Request $request) 
    {
      $this->type = $request->type;
      if ($request->limit) $this->limit = $request->limit;
    }   
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
        $Categories  = Category::get(); 
        return $Categories;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function items(Request $request)
    {
       $Type      = Type::where('type_code',$this->type)->get();  
       $Category  = Category::where('category_code',$request->category)->get();    
       
       $Asset = Asset::where('type_id',$Type[0]->id)
                     ->where('category_id',$Category[0]->id)
                     ->with('type','category','details','sizes','tags')
                     ->paginate($this->limit);
       return Self::httpResponse($Asset);
    }    

}
