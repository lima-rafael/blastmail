<?php

use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\EmailListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TemplateController;
use App\Http\Middleware\CampaignCreateSessionControl;
use App\Mail\EmailCampaign;
use App\Models\Campaigns;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/email-list', [EmailListController::class, 'index'])->name('email-list.index');
    Route::get('/email-list/create', [EmailListController::class, 'create'])->name('email-list.create');
    Route::post('/email-list/create', [EmailListController::class, 'store']);
    Route::get('/email-list/{emailList}/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('/email-list/{emailList}/subscribers/create', [SubscriberController::class, 'create'])->name('subscribers.create');
    Route::post('/email-list/{emailList}/subscribers/create', [SubscriberController::class, 'store']);
    Route::delete('/email-list/{emailList}/subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    
    Route::resource('template', TemplateController::class);
    // Route::resource('campaigns', CampaignsController::class)->only(['index', 'destroy']);
    Route::get('/campaigns', [CampaignsController::class, 'index'])->name('campaigns.index');
    Route::delete('/campaigns/{campaigns}/destroy', [CampaignsController::class, 'destroy'])->name('campaigns.destroy');
    Route::get('/campaigns/create/{tab?}', [CampaignsController::class, 'create'])
    ->middleware(CampaignCreateSessionControl::class)
    ->name('campaigns.create');
    Route::post('/campaigns/create/{tab?}', [CampaignsController::class, 'store']);
    Route::get('/campaigns/{campaigns}/{what?}', [CampaignsController::class, 'show'])->name('campaigns.show');
    Route::patch('/campaigns/{campaigns}/restore', [CampaignsController::class, 'restore'])->withTrashed()->name('campaigns.restore');
    
});

require __DIR__.'/auth.php';
