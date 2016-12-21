<?php 

namespace App\Assets\Types;

use App\Assets\Asset;
use App\Assets\Types\PhotoAssetInterface;
use App\Type;
use App\Category;
use App\Tag;
use App\Asset as AssetData;
use App\AssetDetail;
use App\AssetColor;
use App\AssetSize;
use App\AssetTag;
use PHPExif\Reader\Reader;


class Photo extends Asset
{
  
  protected $asset_sizes_data = [];
  protected $exif_data;


  public function __construct(PhotoAssetInterface $asset) 
  {
    $this->type = $asset->getType();
    $this->sizes = $asset->getsizes();
    $this->output_Json_doc = $asset->getOutputJsonDoc();
    $this->s3_upload = $asset->getS3Upload();
  }
 
  
  public function generateImage($size, $image_input, $image_output) {
    // open an image file
    $img = \Image::make($image_input);
    // resize image instance
    $img->resize($size, null, function ($constraint) {
        $constraint->aspectRatio();
    });  
    // save image in desired format
    $img->save($image_output);      
  } 
  
  
  private function generateImageSizes($image_input, $asset_id, $category_code) {
    
    $dir_hash = str_random(15);
    $type = $this->type;
    $this->asset_sizes_data = [];
    
    foreach ($this->sizes as $size) :
      
      //make output directory
      $filename = $this->extractFilename($image_input);
      $filename_dirname = public_path() . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $dir_hash . DIRECTORY_SEPARATOR . str_pad($asset_id, 10, "0", STR_PAD_LEFT) . DIRECTORY_SEPARATOR . $size; 
      \File::makeDirectory($filename_dirname, 0755, true, true);
      
      //save image
      $new_filename = str_slug($filename['filename']);
      $image_output = $filename_dirname . DIRECTORY_SEPARATOR . $new_filename . '.' . $filename['extension'];
      $this->generateImage($size, $image_input, $image_output);

      //image properties
      $height = \Image::make($image_output)->height();
      $width = \Image::make($image_output)->width();
      $urls = $this->getPublicUrls($asset_id, $type, $height, $width, $dir_hash, $new_filename . '.' . $filename['extension']);
      $this->asset_sizes_data[] = compact( "height", "width", "urls" );
      
    endforeach;
    
  }
  
  
  private function readImageExif($image_input) {
    $exif_reader = Reader::factory(Reader::TYPE_NATIVE);
    $this->exif_data = $exif_reader->read($image_input);
  }
  
  
  public function getCategoryCode($image_input) {
    $filename = $this->extractFilename($image_input);
    $category_code = $this->getBasefolder( $filename['dirname'] );    
    $category_code = str_slug($category_code, "-");
    return $category_code;    
  } 
  
  
  private function saveType($type_name) {
    $type = Type::where('type_code',$type_name)->get();  
    if ($type->isEmpty()) {
      $new_type = new Type;
      $new_type->type_name = $this->reverse_str_slug($type_name);
      $new_type->type_code = $type_name;
      $new_type->save();
      return $new_type->id;
    }
    return $type[0]->id;
  }
  
  
  private function saveCategory($category_code) {
    $category = Category::where('category_code',$category_code)->get();  
    if ($category->isEmpty()) {
      $new_category = new Category;
      $new_category->category_name = $this->reverse_str_slug($category_code);
      $new_category->category_code = $category_code;
      $new_category->save();
      return $new_category->id;
    }
    return $category[0]->id;    
  }  
  
  
  private function saveAsset($type_id, $category_id, $image_input) {
    //Regenerate Asset if checksum exists
    $this->validateAssetChecksum($image_input, true);
    //Save New Asset
    $Asset = new AssetData;
    $Asset->type_id       = $type_id; 
    $Asset->category_id   = $category_id; 
    $Asset->title         = (string) $this->exif_data->getTitle(); 
    $Asset->caption       = (string) $this->exif_data->getCaption();  
    $Asset->author        = (string) $this->exif_data->getAuthor();        
    $Asset->mime_type     = (string) $this->exif_data->getMimeType(); 
    $Asset->file_name     = $this->extractFilename($image_input, false);
    $Asset->file_checksum = sha1_file($image_input);
    $this->fallbackAsset($Asset);
    $Asset->save();   
    return $Asset->id;    
  }       
  
  
  private function fallbackAsset(&$Asset) {
    $image_input = $this->getFirstFile();
    $filename = $this->extractFilename($image_input);
    $filename['filename'] = str_slug($filename['filename']);
    $filename['filename'] = trim( preg_replace("/[^a-zA-Z\-]/", "", $filename['filename']) );
    if (empty($Asset->title)) $Asset->title = $this->reverse_str_slug($filename['filename']);
  }
  
  
  private function saveAssetDetail($asset_id) {
    $AssetDetail = new AssetDetail;
    $AssetDetail->asset_id      = $asset_id;
    $AssetDetail->camera        = $this->exif_data->getCamera(); 
    $AssetDetail->aperture      = $this->exif_data->getAperture(); 
    $AssetDetail->color_space   = $this->exif_data->getColorSpace();
    $AssetDetail->exposure      = $this->exif_data->getExposure(); 
    $AssetDetail->iso           = $this->exif_data->getIso();
    $AssetDetail->focal_length  = $this->exif_data->getFocalLength();
    $AssetDetail->height        = $this->exif_data->getHeight();;
    $AssetDetail->width         = $this->exif_data->getWidth(); 
    $AssetDetail->resolution    = $this->exif_data->getHorizontalResolution();
    $AssetDetail->orientation   = $this->exif_data->getOrientation();
    $AssetDetail->software      = $this->exif_data->getSoftware();
    $AssetDetail->file_size     = $this->exif_data->getFileSize();
    $AssetDetail->save();           
  }    
  
  
  private function saveAssetSize($asset_id) {
    foreach ($this->asset_sizes_data as $asset_size) :
      $AssetSize = new AssetSize;
      $AssetSize->asset_id  = $asset_id;
      $AssetSize->asset_url = $asset_size["urls"]["asset_url"]; 
      $AssetSize->cdn_url   = $asset_size["urls"]["cdn_url"];  
      $AssetSize->height    = $asset_size["height"];    
      $AssetSize->width     = $asset_size["width"];    
      $AssetSize->save(); 
    endforeach;
  }  
  
  
  private function saveAssetTag($asset_id) {
    $Asset = AssetData::find($asset_id);    
    if ( !empty($this->exif_data->getKeywords()) && is_array($this->exif_data->getKeywords())  ) :
      foreach ($this->exif_data->getKeywords() as $keyword) :
         $tag_code = str_slug($keyword);
         $tag   = Tag::firstOrCreate(array('tag_code' => $tag_code));
         $tag->tag_code = $tag_code;
         $tag->tag_name = $keyword;
         $tag->save();
         $Asset->tags()->attach($tag);
      endforeach;
    endif;  
  }    
  
  
  private function saveAssetColor($asset_id) {
    $Asset = AssetData::find($asset_id);
    $image_colors = $this->getImageColors();
      foreach ($image_colors as $color) :
        $hsl = $this->RGB2HSL($color['r'], $color['g'], $color['b'], true);
        $AssetColor = new AssetColor;
        $AssetColor->asset_id = $asset_id;
        $AssetColor->red = $color['r'];
        $AssetColor->green = $color['g'];
        $AssetColor->blue = $color['b'];
        $AssetColor->hue = $hsl['h'];
        $AssetColor->sat = $hsl['s'];
        $AssetColor->lum = $hsl['l'];
        $AssetColor->count = $color['count'];
        $AssetColor->save();
      endforeach;       
  }  
  
  
  public function getImageColors() {
    
    $image_input = $this->getFirstFile();  
    $type = $this->type;
    $filename = $this->extractFilename($image_input, false);
    $image_output_dir = public_path() . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . 'colors' . DIRECTORY_SEPARATOR;
    \File::makeDirectory($image_output_dir, 0755, true, true);
    $image_output = $image_output_dir . $filename;
    $this->generateImage(100, $image_input, $image_output);
    $imgsrc = $image_output;
    
    //Check file exist  
    if (!is_file($imgsrc)) return NULL; 
    
    $im = ImageCreateFromJpeg($imgsrc);            
    $imgw = imagesx($im);
    $imgh = imagesy($im);
                          
    $total_pixels   = $imgw*$imgh;
    $pixels_percent = ($imgw*$imgh)*0.01;
    
    $image = new \Imagick(  $imgsrc );
    $image->quantizeImage(20,1,0,false,false);
    $pixels = $image->getImageHistogram();
    $ictr=0; $ictr1=0; $ictr3=0;

    $pixel_ctr = 0;
    $color_ctr = 0;

    foreach($pixels as $p) {    
       $pixel_count = 0;            
       $Colors     = $p->getColor();
       $ColorCount = $p->getColorCount();     
       if ($ColorCount>5) $pixel_ctr += $ColorCount;        
       if ($ColorCount>0) $color_ctr++;     
       $ColorArr[] = array( "r" => $Colors['r'], "g" => $Colors['g'] , "b" => $Colors['b'], "count" => $ColorCount);                
    }       
    $ColorArrS = $this->array_orderby($ColorArr, 'r', SORT_ASC, 'g', SORT_ASC, 'b', SORT_ASC);       
    \File::delete($imgsrc);
    return $ColorArrS;          
  
  }  
      
  
  public function save() {
    
    //Prepare resource data  
    $image_input = $this->getFirstFile();
    $this->readImageExif($image_input);
      
    //Save Type and Category  
    $type_id       = $this->saveType($this->type);
    $category_code = $this->getCategoryCode($image_input);
    $category_id   = $this->saveCategory($category_code);
    
    //Save Asset Records
    $asset_id = $this->saveAsset($type_id, $category_id, $image_input);   
    $this->generateImageSizes( $image_input, $asset_id, $category_code);
    $this->saveAssetDetail($asset_id);
    
    $this->saveAssetColor($asset_id);
    $this->saveAssetTag($asset_id);
    $this->saveAssetSize($asset_id);
    
    //save assets to s3
    if ($this->output_Json_doc) $this->outputJsonDoc($asset_id,$this->type);
    if ($this->s3_upload) $this->uploadS3($asset_id,$this->type);
    
    //remove source asset
    $this->removeSourceAsset($image_input);
    
  }  
  
  
  private function uploadS3($asset_id,$type) {
    $s3 = \Storage::disk('s3');
    foreach ($this->asset_sizes_data as $asset_size) :     
      $filePath = $asset_size["urls"]["file_path"];
      $s3Path = $asset_size["urls"]["s3_path"];
      $s3->put($s3Path, file_get_contents($filePath), 'public');      
    endforeach;    
    if ($this->output_Json_doc) {
      $json_path = public_path() . DIRECTORY_SEPARATOR . 'assets'  . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . 'json' ;
      $json_file = $json_path . DIRECTORY_SEPARATOR . str_pad($asset_id, 10, "0", STR_PAD_LEFT)  . '.json';   
      $s3Path = $type . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . str_pad($asset_id, 10, "0", STR_PAD_LEFT)  . '.json';   
      $s3->put($s3Path, file_get_contents($json_file), 'public');
    }
  }
  
  
  private function outputJsonDoc($asset_id, $type) {
    $json_path = public_path() . DIRECTORY_SEPARATOR . 'assets'  . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . 'json' ;
    $json_file = $json_path . DIRECTORY_SEPARATOR . str_pad($asset_id, 10, "0", STR_PAD_LEFT)  . '.json';
    $AssetData = AssetData::where('id', $asset_id)->with('type','category','details','sizes','tags','colors')->get()->toArray();
    $json_contents = json_encode($AssetData);
    \File::makeDirectory($json_path, 0755, true, true);    
    \File::put($json_file, $json_contents, ['ContentType' => 'applicaton/json' ]);
  } 
  
    
  private function removeSourceAsset($asset_source) {
    \File::delete($asset_source); 
  }  

    
}