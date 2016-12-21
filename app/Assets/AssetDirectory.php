<?php 

namespace App\Assets;

use File;

trait AssetDirectory
{
  
  private $directories = [];
  
  /**
   * Return asset public path.
   *
   * @return string
   */     
    public function getPublicPath() 
    {
       return public_path('/assets/' . $this->type);
    }
    
    
  /**
   * Return asset resource path.
   *
   * @return string
   */    
    public function getResourcePath() 
    {
       return public_path('../resources/assets/' . $this->type);
    }  
  
  
  /**
   * Return asset public directories.
   *
   * @return array
   */     
    public function getPublicDirectories() 
    {
       return File::directories( $this->getPublicPath() );
    }
  
  
  /**
   * Return asset resource directories.
   *
   * @return array
   */    
    public function getResourceDirectories() 
    {
       $this->directories = File::directories( $this->getResourcePath() );
       return $this->directories;
    }    
    
    
  /**
   * Return all assets of given directory.
   *
   * @return array
   */    
    public function getPathAssets($path) 
    {
       return File::files( $path );
    }        
    
    
  /**
   * Return asset count of given directory.
   *
   * @return int
   */    
    public function countPathAssets($path) 
    {
       return count( File::allfiles( $path ) );
    }  


  /**
   * Return top directory or offset from top
   *
   * @return string
   */    
    public function getFirstDirectory($offset=0) 
    {
       return $this->getResourceDirectories()[$offset];   
    }      
    
  /**
   * Return top file of top directory.
   *
   * @return string
   */    
    public function getFirstFile() 
    {
       $firstFile = '';
       $this->getResourceDirectories();
       foreach ($this->directories as $directory) :
         $files = scandir($directory);
         //$files = preg_grep('/^([^.])/', scandir($directory));
         if (!empty($files[3])) {
            $firstFile = $directory . DIRECTORY_SEPARATOR . $files[3]; 
            break;
         }
       endforeach;
       return $firstFile;  
    } 
    
}     
    