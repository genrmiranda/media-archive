<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>     
    <meta name="apple-mobile-web-app-capable" content="yes" />
    
    <title>Media Archive (Photos)</title>
    <meta name="title" content="Media Archive (Photos)" />
    <meta name="type" content="website" />
    <meta name="description" content="CLI and API web application to process, resize and archive large volumes of photos" />
    <meta name="image" content="http://www.genrmiranda.com/social/social-media.jpg" />
    <meta name="robots" content="index, follow" />
    
    <!--facebook-->
    <meta property="og:title" content="Media Archive (Photos)" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="CLI and API web application to process, resize and archive large volumes of photos" />
    <meta property="og:image" content="http://www.genrmiranda.com/social-media-images/social-media-fb.jpg" />
    <meta property="og:robots" content="index, follow" />
    <meta property="fb:app_id" content="1217286901692103" />
    
    <!--twitter-->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@genrmiranda">
    <meta name="twitter:title" content="Media Archive (Photos)">
    <meta name="twitter:description" content="CLI and API web application to process, resize and archive large volumes of photos">
    <meta name="twitter:image" content="http://www.genrmiranda.com/social-media-images/social-media-tw.jpg">
    
    <!--favicons-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://www.genrmiranda.com/favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="http://www.genrmiranda.com/favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="http://www.genrmiranda.com/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="http://www.genrmiranda.com/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="http://www.genrmiranda.com/favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="http://www.genrmiranda.com/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="http://www.genrmiranda.com/favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="http://www.genrmiranda.com/favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="http://www.genrmiranda.com/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="http://www.genrmiranda.com/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="http://www.genrmiranda.com/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="http://www.genrmiranda.com/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="http://www.genrmiranda.com/favicons/favicon-16x16.png">
    <link rel="manifest" href="http://www.genrmiranda.com/favicons/manifest.json">
    <link rel="mask-icon" href="http://www.genrmiranda.com/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="msapplication-TileImage" content="http://www.genrmiranda.com/favicons/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">     
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->        
    
    
    <link rel="canonical" href="http://yousendit.genrmiranda.com/" />         
    
  </head>

  <body>
  
    <!-- main -->
    <div id="main">
      
      <div class="jumbotron">
        <div class="container">
          <h1>Media Archive (Photos)</h1>
          <p>CLI and API web application to process, resize and archive large volumes of photos</p>
          <p><a class="btn btn-primary btn-lg" href="https://github.com/genrmiranda/media-archive" target="_blank" role="button">Fork on GitHub</a></p>          
        </div>   
      </div>      
    
      <!-- container -->
      <div class="container">
        
        <h3>Developed with Laravel 5.1 PHP Framework</h3>
        
        <h3>AWS Cloud Application</h3>
        
        <h3>&nbsp;</h3>
        <h3>Features:</h3>
        
        <ul>
           <li>Resize photos</li>
           <li>Extract Exif/IPTC Metadata</li>
           <li>Extract colors</li>
           <li>Automatically categorize your photos</li>
           <li>Generate JSON document</li>
           <li>Upload to S3</li>
           <li>CLI operations</li>
           <li>API service</li>
        </ul>
        
        <h3>&nbsp;</h3>
        <h3>API Demo Endpoints:</h3>
        
        <blockquote>
        <h4>Get List of Categories</h4>
        <p><a href="http://media-archive.genrmiranda.com/api/v1/asset/category/list">http://media-archive.genrmiranda.com/api/v1/asset/category/list</a></p>
        </blockquote>
        
        <blockquote>
        <h4>Get Asset Data</h4>
        <p><a href="http://media-archive.genrmiranda.com/api/v1/asset/333">http://media-archive.genrmiranda.com/api/v1/asset/333</a></p>
        </blockquote>        
       
        <blockquote>
        <h4>Get All Photos</h4>
        <p><a href="http://media-archive.genrmiranda.com/api/v1/asset/photos/items">http://media-archive.genrmiranda.com/api/v1/asset/photos/items</a></p>
        </blockquote>         

        <blockquote>
        <h4>Get Photos by Category</h4>
        <p><a href="http://media-archive.genrmiranda.com/api/v1/asset/photos/category/landscapes-nature/items">http://media-archive.genrmiranda.com/api/v1/asset/photos/category/landscapes-nature/items</a></p>
        </blockquote>  

        <blockquote>
        <h4>Search Photos by Keyword</h4>
        <p><a href="http://media-archive.genrmiranda.com/api/v1/asset/photos/search?keyword=art">http://media-archive.genrmiranda.com/api/v1/asset/photos/search?keyword=art</a></p>
        </blockquote>                   

        <blockquote>
        <h4>Search Photos by Color</h4>
        <p><a href="http://media-archive.genrmiranda.com/api/v1/asset/photos/search/color?rgb=45.50.120">http://media-archive.genrmiranda.com/api/v1/asset/photos/search/color?rgb=45.50.120</a></p>
        <p><a href="http://media-archive.genrmiranda.com/api/v1/asset/photos/search/color?hsl=220.30.60">http://media-archive.genrmiranda.com/api/v1/asset/photos/search/color?hsl=220.30.60</a></p>
        <p><a href="http://media-archive.genrmiranda.com/api/v1/asset/photos/search/color?hex=637AAF">http://media-archive.genrmiranda.com/api/v1/asset/photos/search/color?hex=637AAF</a></p>
        </blockquote>                   
                                      
        <h3>&nbsp;</h3>
      
      </div> 
      <!-- container-fluid -->
    
    </div>
    <!-- main -->
 
    
  
    <!-- scripts -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-88811411-3', 'auto');
      ga('send', 'pageview');
    
    </script>     
    
  </body>
</html>       
