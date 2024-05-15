<?php

namespace BizyTech\Auth\Tests\TestModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\AuthorizeUserTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{
    use HasRoles,AuthorizeUserTrait;
    protected $guarded = [];
}
