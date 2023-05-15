<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware(['auth', 'verified'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware(['auth', 'verified'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware(['auth', 'verified'])->name('profile.destroy');
});
Route::post('/single/charge', [HomeController::class, 'singlecharge'])->middleware(['auth', 'verified'])->name('single.charge');
Route::get('/show/plan', [SuscriptionController::class, 'showplan'])->middleware(['auth', 'verified'])->name('plan.show');
Route::post('/store/plan', [SuscriptionController::class, 'savePlan'])->middleware(['auth', 'verified'])->name('plan.save');

Route::get('/show/allplan', [SuscriptionController::class, 'showallPlan'])->middleware(['auth', 'verified'])->name('allplan.show');
Route::get('/plan/checkout{planid}', [SuscriptionController::class, 'chackoutPlan'])->middleware(['auth', 'verified'])->name('plan.chackout');
Route::post('/plan/process', [SuscriptionController::class, 'processPlan'])->middleware(['auth', 'verified'])->name('plan.process');

Route::get('/subscription/table', [SuscriptionController::class, 'subscriptionshow'])->middleware(['auth', 'verified'])->name('subscription.show');
Route::get('/subscription/cancel', [SuscriptionController::class, 'cancelsubscription'])->middleware(['auth', 'verified'])->name('subscription.cancel');
Route::get('/subscription/resume', [SuscriptionController::class, 'resumesubscription'])->middleware(['auth', 'verified'])->name('subscription.resume');
require __DIR__.'/auth.php';
