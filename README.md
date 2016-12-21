# Media Archive (Photos)

CLI and API web application to process, resize and archive large volumes of photos.

* Developed with Laravel 5.1 PHP Framework.

* AWS Cloud Application


### Features

* Resize photos
* Extract Exif/IPTC Metadata
* Extract colors
* Automatically categorize your photos
* Generate JSON document
* Upload to S3
* CLI operations
* API service


### System Requirements

* PHP >= 5.5.9
* MySQL
* Composer
* ImageMagick
* AWS S3 (Optional)


### Installation

Install Laravel Depedencies
```
$ composer install
```

Copy _env.example_ to _.env_
```
$ cp env.example .env
```

Edit _.env_ configuration file
```
...
DB_CONNECTION=mysql
DB_HOST=db-host
DB_DATABASE=db-name
DB_USERNAME=db-user
DB_PASSWORD=db-password
....
S3_KEY=s3-credential
S3_SECRET=s3-credential-secret
S3_REGION=aws-region-name
S3_BUCKET=s3-bucket-name
....
CDN_DOMAIN=cdn-domain
ASSET_DOMAIN=asset-domain
WEBSITE_DOMAIN=website-domain
...
```

Create Database
```
$ php artisan migrate
```


### Assets Folders

Place photos to process in the the _resource/assets/photos_ folder
* Put your photos under subfolder which will serve as the _Category Name_ of your photos

```
resources
└── assets
    └── photos
        └── Category Name 1    
            ├── image1.jpg
            ├── image2.jpg
            ├── image3.jpg   
            ├── ...               
        └── Category Name 2    
            ├── image1.jpg
            ├── image2.jpg
            ├── image3.jpg   
            ├── ...
```

Resized photos will be stored in the _public/assets/photos_ folder

```
public
└── assets
    └── photos
        ├── ...
```



## CLI Commands


### Command Syntax

```
$ php artisan asset:generate --help
```

```
Usage:
  assets:generate [options] [--] [<type>]

Arguments:
  type                                      [default: "photos"]

Options:
      --count[=COUNT]                      Limit count of assets to process [default: "1"]
      --width-sizes[=WIDTH-SIZES]          Generate sizes (separate multiple sizes by comma) [default: "300,800"]
      --s3-upload[=S3-UPLOAD]              Upload asset to S3 bucket (configure S3 on .env) [default: "false"]
      --output-json-doc[=OUTPUT-JSON-DOC]  Generate json file for each asset [default: "false"]
  -h, --help                               Display this help message
  -q, --quiet                              Do not output any message
  -V, --version                            Display this application version
      --ansi                               Force ANSI output
      --no-ansi                            Disable ANSI output
  -n, --no-interaction                     Do not ask any interactive question
      --env[=ENV]                          The environment the command should run under.
  -v|vv|vvv, --verbose                     Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
  Generate resource media asset
```


### Command Example
```
php artisan asset:generate photos --width-sizes=300,800 --count=10000 --output-json-doc=true --s3-upload=true
```
Command will:
* Process 10000 photos from the _resources/assets/photos_ folder
* Resize photos with 300 widths and 800 widths (height aspect ratio is calculated automatically)
* Generate JSON document for each photos
* Upload resized photos _public/assets/photos_ folder to S3 as well



## JSON Documents

output-json-doc set to true will generate JSON document for each asset which you can import to NoSQL, and Search Engine like Solr and ElasticSearch
```
 --output-json-doc=true
```

Location of generated JSON documents:

```
public
└── assets
    └── json
        ├── 0000000001.json
        ├── 0000000002.json
        ├── 0000000003.json
        ├── ....
```


## API Endpoints



### Get List of Categories

```
GET api/v1/asset/category/list
```

##### Demo API Endpoint:

http://media-archive.genrmiranda.com/api/v1/asset/category/list

```
[
  {
    "category_code": "backgrounds-textures",
    "category_name": "Backgrounds Textures"
  },
  {
    "category_code": "food-drinks",
    "category_name": "Food Drinks"
  },
  {
    "category_code": "interiors",
    "category_name": "Interiors"
  },
  {
    "category_code": "landmarks-buildings",
    "category_name": "Landmarks Buildings"
  },
  {
    "category_code": "landscapes-nature",
    "category_name": "Landscapes Nature"
  }
]
```

### Get Asset Data

```
GET api/v1/asset/:id
```

| Name   | Type     | Description           |
---------|:---------|:----------------------|
| id     | integer  | Asset unique ID       |


##### Demo API Endpoint:

http://media-archive.genrmiranda.com/api/v1/asset/333

```
[
  {
    "id": "333",
    "title": "Arabic Pattern ",
    "caption": "Arabic Pattern",
    "author": "",
    "file_name": "arabic_pattern_0000051207.jpg",
    "mime_type": "image/jpeg",
    "created_at": "2016-12-19 19:35:41",
    "updated_at": "2016-12-19 19:35:41",
    "type": {
      "type_code": "photos",
      "type_name": "Photos"
    },
    "category": {
      "category_code": "backgrounds-textures",
      "category_name": "Backgrounds Textures"
    },
    "details": {
  ...
]
```


### Get All Photos 

```
GET api/v1/asset/:type/items 
```

| Name      | Type     | Description                      |
------------|:---------|:---------------------------------|
| type      | string   | Asset type default: photos       |


##### Demo API Endpoint:

http://media-archive.genrmiranda.com/api/v1/asset/photos/items

```
{
  "total": 13684,
  "per_page": 25,
  "current_page": 1,
  "last_page": 548,
  "next_page_url": "http://media-archive.genrmiranda.com/api/v1/asset/photos/items?page=2",
  "prev_page_url": null,
  "from": 1,
  "to": 25,
  "data": [
    {
      "id": "1",
      "title": "Th Century Tin Mel Mosque High Atlas Mountains Marrakech Morocco",
      "caption": "",
      "author": "",
      "file_name": "12th_century_tin_mel_mosque_high_atlas_mountains_marrakech_morocco_0000123557.jpg",
      "mime_type": "image/jpeg",
      "created_at": "2016-12-19 19:15:36",
      "updated_at": "2016-12-19 19:15:36",
      "type": {
        "type_code": "photos",
        "type_name": "Photos"
      },
      "category": {
        "category_code": "backgrounds-textures",
        "category_name": "Backgrounds Textures"
      },
      "details": {
  ...
]
```


### Get Photos by Category 

```
GET api/v1/asset/:type/category/:category/items
```

| Name      | Type     | Description                      |
------------|:---------|:---------------------------------|
| type      | string   | Asset type default: photos       |
| category  | string   | Category Name                    |


##### Demo API Endpoint:

http://media-archive.genrmiranda.com/api/v1/asset/photos/category/landscapes-nature/items

```

  "total": 4616,
  "per_page": 25,
  "current_page": 1,
  "last_page": 185,
  "next_page_url": "http://media-archive.genrmiranda.com/api/v1/asset/photos/category/landscapes-nature/items?page=2",
  "prev_page_url": null,
  "from": 1,
  "to": 25,
  "data": [
    {
      "id": "9072",
      "title": "40 Years of UAE - Spirit of The Union poster in Dubai, United Arab Emirates. Photo taken at 20th of January 2012",
      "caption": "40 Years of UAE - Spirit of The Union poster in Dubai, United Arab Emirates. Photo taken at 20th of January 2012",
      "author": "",
      "file_name": "40_years_of_uae_spirit_of_the_union_poster_in_dubai_united_arab_emirates_photo_taken_at_20th_of_january_2012_0000038878.jpg",
      "mime_type": "image/jpeg",
      "created_at": "2016-12-20 01:44:30",
      "updated_at": "2016-12-20 01:44:30",
      "type": {
        "type_code": "photos",
        "type_name": "Photos"
      },
      "category": {
        "category_code": "landscapes-nature",
        "category_name": "Landscapes Nature"
      },
      "details": {
  ...
]
```


### Search Photos by Keyword

```
GET api/v1/asset/:type/search?keyword=:keyword
```

| Name      | Type     | Description                      |
------------|:---------|:---------------------------------|
| type      | string   | Asset type default: photos       |
| keyword   | string   | Keyword to search                |


##### Demo API Endpoint:

http://media-archive.genrmiranda.com/api/v1/asset/photos/search?keyword=art

```
{
  "total": 948,
  "per_page": 25,
  "current_page": 1,
  "last_page": 38,
  "next_page_url": "http://media-archive.genrmiranda.com/api/v1/asset/photos/search?page=2",
  "prev_page_url": null,
  "from": 1,
  "to": 25,
  "data": [
    {
      "id": "3",
      "title": "A Ottoman Gravestone At Eyup Istanbul",
      "caption": "",
      "author": "Leyla S. Ismet",
      "file_name": "a_ottoman_gravestone_at_eyup_istanbul_0000069071.jpg",
      "mime_type": "image/jpeg",
      "created_at": "2016-12-19 19:15:41",
      "updated_at": "2016-12-19 19:15:41",
      "type": {
        "type_code": "photos",
        "type_name": "Photos"
      },
      "category": {
        "category_code": "backgrounds-textures",
        "category_name": "Backgrounds Textures"
      },
      "details": {
  ...
]
```


### Search Photos by Color


```
GET api/v1/asset/:type/search/color?rgb=:color
```

```
GET api/v1/asset/:type/search/color?hsl=:color
```

```
GET api/v1/asset/:type/search/color?hex=:color
```

| Name      | Type            | Format   | Description                      |
------------|:----------------|:---------|:---------------------------------|
| type      | string          |          | Asset type default: photos       |
| rgb       | dot delimited   | R.G.B    | Search RGB Color                 |
| hsl       | dot delimited   | H.S.L    | Search HSL Color                 |
| hex       | string          | Hex Code | Search HEX Color                 |


##### Demo API Endpoint:

http://media-archive.genrmiranda.com/api/v1/asset/photos/search/color?rgb=45.50.120

http://media-archive.genrmiranda.com/api/v1/asset/photos/search/color?hsl=220.30.60

http://media-archive.genrmiranda.com/api/v1/asset/photos/search/color?hex=637AAF

---