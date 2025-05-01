<?php

use App\Livewire\HomeComponent;
use App\Livewire\UserComponent;
use App\Livewire\LevelComponent;
use App\Livewire\CertificateComponent;
use App\Livewire\AnalisisComponent;
use App\Livewire\GestionComponent;
use App\Livewire\EstrategiaComponent;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

// Publicas
Route::get('/', HomeComponent::class)->name('home');

// Privadas
Route::get('/person', UserComponent::class)->middleware(['auth']);
Route::get('/analysis', AnalisisComponent::class)->middleware(['auth']);
Route::get('/gestion', GestionComponent::class)->middleware(['auth']);
Route::get('/estrategia', EstrategiaComponent::class)->middleware(['auth']);
Route::get('/levels/{personId}', LevelComponent::class)->middleware(['auth']);
Route::get('/certificado-final/{personId}',CertificateComponent::class)->middleware(['auth']);




require __DIR__.'/auth.php';
