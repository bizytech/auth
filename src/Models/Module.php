<?php

namespace BizyTech\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use \Illuminate\Database\Eloquent\Model as Eloquent;

class Module extends Eloquent
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public function permissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Permission::class,"module_id");
    }
}
