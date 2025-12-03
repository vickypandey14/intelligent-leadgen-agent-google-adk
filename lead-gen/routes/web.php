<?php

use App\Http\Controllers\LeadSearchController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/lead/search', [LeadSearchController::class, 'index'])->name('lead.search');
Route::post('/lead/search', [LeadSearchController::class, 'search'])->name('lead.search.run');
Route::get('/lead/list', [LeadSearchController::class, 'list'])->name('lead.list');
