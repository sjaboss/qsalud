<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Api\Auth\RegisterController;
use  App\Http\Controllers\Api\PostController; 
use App\Http\Controllers\Api\Auth\LoginController;

Route::post('login', [LoginController::class,'store']);

Route::post('register', [RegisterController::class,'store'])->name('api.v1.register');


/* Route::get('categories',[CategoryController::class,'index'])->name('api.v1.categories.index');  Javi esta va muestrar todas las categorias*/
/* Route::post('categories',[CategoryController::class,'store'])->name('api.v1.categories.store');   Javi esta agrega nuevos registros a nuestra base tabla category */
/* Route::get('categories/{category}',[CategoryController::class,'show'])->name('api.v1.categories.show');  Javi esta va mostrar una categoria en especifico */
/* Route::put('categories/{category}',[CategoryController::class,'update'])->name('api.v1.categories.update');  Javi esta va a modificar una categoria en especifico */
/* Route::delete('categories/{category}',[CategoryController::class,'destroy'])->name('api.v1.categories.delete');  Javi esta va a eliminar una categoria en especifico */


/* --------------------------------------------------------------------------------
Javi manera resumida de crear estas rutas para una Api es de la siguiente manera. Pero se debe usar solo si en el controlador
 ya estan creados los metos index, storage delete..etc 
|--------------------------------------------------------------------------
| API Routes para categories
|--------------------------------------------------------------------------*/
 Route::apiResource('categories',CategoryController::class)->names('api.v1.categories');  
 Route::apiResource('post',PostController::class)->names('api.v1.post');   




/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
