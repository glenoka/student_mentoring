<?php

use App\Livewire\HomePage;
use App\Livewire\PublicImageMaterial;
use App\Livewire\PublicVideosMaterial;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);
Route::get('/images/{uuid}', PublicImageMaterial::class)
    ->name('images.public.show');
    Route::get('/videos/{uuid}', PublicVideosMaterial::class)
    ->name('videos.public.show');