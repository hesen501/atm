<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'password',
        'daily_limit',
        'role',
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }
}
