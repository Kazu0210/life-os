<?php

namespace Modules\Emails\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['email'])]
class Email extends Model
{
    protected $table = 'emails';
}
