<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioController;
use App\Http\Controllers\ChatbotController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/twilio/webhook', [TwilioController::class, 'handleWebhook']);
Route::post('/chatbot', [ChatbotController::class, 'handleChatbot']);

// jJ1fpwpmW7EMSTeXZhQ9OHzMdjHXyusea6UOZdD0lxM=