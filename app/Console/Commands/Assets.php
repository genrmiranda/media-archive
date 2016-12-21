<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Assets\Types\Photo;
use App\Assets\Types\PhotoAsset;

class Assets extends Command
{
  
    private $count;
    private $supported_types = ['photos'];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assets:generate 
                              {type=photos} 
                              {--count=1 : Limit count of assets to process} 
                              {--width-sizes=300,800 : Generate sizes (separate multiple sizes by comma)}
                              {--s3-upload=false : Upload asset to S3 bucket (configure S3 on .env)}
                              {--output-json-doc=false : Generate json file for each asset}
                              ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate resource media asset';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      
      if (in_array($this->argument('type'), $this->supported_types)) { 
        if ($this->argument('type')=='photos') $this->generatePhotos();
      }
      echo PHP_EOL;
  
      if (!in_array($this->argument('type'), $this->supported_types)) { 
        echo "Media type not supported.";
      }     
      echo PHP_EOL;
 
    }
    
    
    /**
     * Execute the console generate photos
     *
     * @return void
     */    
    private function generatePhotos() {
      
      $this->count = $this->option('count');      
      $photo_asset = new PhotoAsset();
      $photo_asset->setType( $this->argument('type') );
      $photo_asset->setSizes( $this->option('width-sizes') );
      $photo_asset->setOutputJsonDoc( $this->option('output-json-doc') );
      $photo_asset->setS3Upload( $this->option('s3-upload') );
     
      $asset = new Photo( $photo_asset );     
       
      $bar = $this->output->createProgressBar( $this->count );          
      for ($n=0; $n<$this->option('count'); $n++) {
          $bar->advance();
          if (is_file($asset->getFirstFile())) {
            $asset->save();
          }
      }
      
      $bar->finish();      
      
    }

}
