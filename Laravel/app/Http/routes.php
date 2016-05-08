<?php

Route::get('update/{function_name}/{id?}', 'UpdateController@index');


Route::group(['prefix'=>'/admin'],function(){
    Route::get('/', 'AdminController@index');
    Route::get('/login', 'loginController@index');
    Route::post('/login/confirmlogin', 'loginController@confirmlogin');
    Route::group(['prefix'=>'/product'],function(){
        Route::group(['prefix'=>'/category'],function(){
            Route::get('/', 'ProductCategoryController@index');
            Route::get('/add', 'ProductCategoryController@add');
            Route::get('/edit/{id}', 'ProductCategoryController@edit');
            Route::get('/delete', 'ProductCategoryController@delete');
            Route::get('/checkstatus/{val}/{id}', 'ProductCategoryController@checkstatus');
            Route::get('/changeorder/{val}/{id}', 'ProductCategoryController@changeorder');
            Route::post('/confirmadd', 'ProductCategoryController@confirmadd');
            Route::post('/confirmedit', 'ProductCategoryController@confirmedit');
        });
        Route::group(['prefix'=>'/list'],function(){
            Route::get('/', 'ProductListController@index');
            Route::get('/add', 'ProductListController@add');
            Route::get('/getCategoryNews', 'ProductListController@getCategoryNews');
            Route::get('/getCategoryProduct', 'ProductListController@getCategoryProduct');
            Route::get('/edit/{id}', 'ProductListController@edit');
            Route::get('/updatelist', 'ProductListController@updatelist');
            //updatelist
            Route::get('/deleteAll', 'ProductListController@deleteAll');
            Route::get('/checkstatus/{val}/{id}', 'ProductListController@checkstatus');
            Route::get('/changeorder/{val}/{id}', 'ProductListController@changeorder');
            Route::post('/confirmadd', 'ProductListController@confirmadd');
            Route::post('/confirmedit', 'ProductListController@confirmedit');
            Route::get('/updatedataproduct', 'ProductListController@updatedataproduct');
            Route::get('/exportExcel', 'ProductListController@exportExcel');
            Route::get('/importExcel', 'ProductListController@importExcel');
        });
        
        
        
        
        
        Route::group(['prefix'=>'/procedure'],function(){
            Route::get('/', 'ProductProcedureController@index');
            Route::get('/add', 'ProductProcedureController@add');
            Route::get('/edit/{id}', 'ProductProcedureController@edit');
            Route::get('/delete/{id}', 'ProductProcedureController@delete');
            Route::get('/checkstatus/{val}/{id}', 'ProductProcedureController@checkstatus');
            Route::get('/changeorder/{val}/{id}', 'ProductProcedureController@changeorder');
            Route::post('/confirmadd', 'ProductProcedureController@confirmadd');
            Route::post('/confirmedit', 'ProductProcedureController@confirmedit');
        });
        Route::group(['prefix'=>'/tags'],function(){
            Route::get('/', 'ProductTagsController@index');
            Route::get('/add', 'ProductTagsController@add');
            Route::get('/edit', 'ProductTagsController@edit');
            Route::get('/delete', 'ProductTagsController@delete');
        });
        Route::group(['prefix'=>'/filter'],function(){
            Route::get('/', 'ProductFilterController@index');
            Route::get('/addgroup', 'ProductFilterController@addgroup');
            Route::get('/editgroup', 'ProductFilterController@editgroup');
            Route::get('/deletegroup', 'ProductFilterController@deletegroup');
            Route::get('/additem', 'ProductFilterController@additem');
            Route::get('/edititem', 'ProductFilterController@edititem');
            Route::get('/deleteitem', 'ProductFilterController@deleteitem');
        });
        /*Route::group(['prefix'=>'/filterdefault'],function(){
            Route::get('/', 'ProductFilterController@index');
            Route::get('/addgroup', 'ProductFilterController@addgroup');
            Route::get('/editgroup', 'ProductFilterController@editgroup');
            Route::get('/deletegroup', 'ProductFilterController@deletegroup');
            Route::get('/additem', 'ProductFilterController@additem');
            Route::get('/edititem', 'ProductFilterController@edititem');
            Route::get('/deleteitem', 'ProductFilterController@deleteitem');
        });*/
    });
    Route::group(['prefix'=>'/news'],function(){
        Route::group(['prefix'=>'/category'],function(){
            Route::get('/', 'NewsCategoryController@index');
            Route::get('/add', 'NewsCategoryController@add');
            Route::get('/edit/{id}', 'NewsCategoryController@edit');
            Route::get('/delete', 'NewsCategoryController@delete');
            Route::get('/checkstatus/{val}/{id}', 'NewsCategoryController@checkstatus');
            Route::get('/changeorder/{val}/{id}', 'NewsCategoryController@changeorder');
            Route::post('/confirmadd', 'NewsCategoryController@confirmadd');
            Route::post('/confirmedit', 'NewsCategoryController@confirmedit');
        });
        Route::group(['prefix'=>'/list'],function(){
            Route::get('/', 'NewsListController@index');
            Route::get('/add', 'NewsListController@add');
            Route::get('/edit/{id}', 'NewsListController@edit');
            Route::get('/updatelist', 'NewsListController@updatelist');
            Route::get('/delete/{id}', 'NewsListController@delete');
            Route::get('/deleteAll', 'NewsListController@deleteAll');
            Route::get('/ExportExcel', 'NewsListController@ExportExcel');
            Route::get('/ImportExcel', 'NewsListController@ImportExcel');
            Route::get('/checkstatus/{val}/{id}', 'NewsListController@checkstatus');
            Route::get('/changeorder/{val}/{id}', 'NewsListController@changeorder');
            Route::post('/confirmadd', 'NewsListController@confirmadd');
            Route::post('/confirmedit', 'NewsListController@confirmedit');
            
        });
        Route::group(['prefix'=>'/tags'],function(){
            Route::get('/', 'NewsTagsController@index');
            Route::get('/add', 'NewsTagsController@add');
            Route::get('/edit', 'NewsTagsController@edit');
            Route::get('/delete', 'NewsTagsController@delete');
        });
    });
    Route::group(['prefix'=>'/design'],function(){
        Route::group(['prefix'=>'/page'],function(){
            Route::post('/update', 'DesignPageController@update');
            Route::get('/delete', 'DesignPageController@delete');
            Route::get('/fields', 'DesignPageController@fields');
            Route::get('/{id?}/{type?}', 'DesignPageController@index');
        });
        Route::group(['prefix'=>'/template'],function(){
            Route::post('/update', 'DesignTemplateController@update');
            Route::get('/delete', 'DesignTemplateController@delete');
            Route::get('/applypage/{id}', 'DesignTemplateController@applypage');
            Route::get('/{id?}', 'DesignTemplateController@index');
        });
        Route::group(['prefix'=>'/modul'],function(){
            Route::get('/getDataModul', 'DesignModulController@getDataModul');
            Route::get('/getDataFrame', 'DesignModulController@getDataFrame');
            Route::post('/update', 'DesignModulController@update');
            Route::get('/delete/{id}', 'DesignModulController@delete');
            Route::get('/{id?}', 'DesignModulController@index');
            
        });
        Route::group(['prefix'=>'/item'],function(){
            Route::get('/{id}/{item?}', 'DesignItemController@index');
            Route::post('/update', 'DesignItemController@update');
            Route::get('/delete/{id}/{item}', 'DesignItemController@delete');
        });
        Route::group(['prefix'=>'/libcssjs'],function(){
            Route::get('/', 'DesignLibCssJsController@index');
            Route::get('/update', 'DesignLibCssJsController@add');
            Route::get('/delete', 'DesignLibCssJsController@delete');
        });
    });
    Route::group(['prefix'=>'/customer'],function(){
        Route::get('/commentnews', 'CustomerCommentNewsController@index');
        Route::get('/commentnewsedit', 'CustomerCommentNewsController@edit');
        
    });
});
Route::get('/{url?}', 'WebsiteController@index');