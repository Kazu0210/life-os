<?php

use Illuminate\Support\Facades\Route;
use Modules\Emails\Http\Controllers\EmailsController;

Route::resource('emails', EmailsController::class)->names('emails');