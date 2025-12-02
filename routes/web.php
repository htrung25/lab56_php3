<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::resource('movies', MovieController::class);

/*
    Dòng trên sẽ tự động tạo 7 route sau:
    GET      /movies          → movies.index
    GET      /movies/create   → movies.create
    POST     /movies          → movies.store
    GET      /movies/{movie}  → movies.show
    GET      /movies/{movie}/edit → movies.edit
    PUT      /movies/{movie}  → movies.update
    DELETE   /movies/{movie}  → movies.destroy
*/