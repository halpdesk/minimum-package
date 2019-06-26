<?php

namespace Halpdesk\LaravelMinimumPackage\Models;

use Illuminate\Database\Eloquent\Model;
use Halpdesk\LaravelMinimumPackage\Contracts\User as UserContract;

class User extends Model implements UserContract
{
    protected $table = 'users';
    protected $fillable = [
        'name',
    ];
}
