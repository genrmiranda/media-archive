<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

  Route::get('/', function () {
      return view('welcome');    
  });

  //API Routes
  Route::group(['prefix' => 'api/v1', 'as' => 'API::'], function () {
      Route::group(['as' => 'assets::'], function () {
        Route::get('asset/{id}',                              ['as' => 'asset-id',       'uses' => 'APIV1AssetsController@show']);
        Route::get('asset/{type}/items',                      ['as' => 'asset-items',    'uses' => 'APIV1AssetsController@items']);
        Route::get('asset/{type}/search',                     ['as' => 'search-keyword', 'uses' => 'APIV1AssetsController@searchKeyword']);
        Route::get('asset/{type}/search/color',               ['as' => 'search-color',   'uses' => 'APIV1AssetsController@searchColor']);
        Route::get('asset/category/list',                     ['as' => 'category-list',  'uses' => 'APIV1CategoriesController@categories']);
        Route::get('asset/{type}/category/{category}/items',  ['as' => 'category-items', 'uses' => 'APIV1CategoriesController@items']);
      });   
  });
