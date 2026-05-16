<?php

use Illuminate\Support\Facades\Route;
use Modules\Emails\Http\Controllers\EmailsController;

Route::get('emails/data', [EmailsController::class, 'data'])->name('emails.data');
Route::resource('emails', EmailsController::class)->names('emails');
