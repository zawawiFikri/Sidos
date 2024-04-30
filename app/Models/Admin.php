<?php

namespace App\Models;

use App\Models\User;
use App\Models\Req;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    protected $fillable = [
        'nidn',
        'user_id',
        'foto_profil',
    ];

    public function user():BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id');
    }

    public function request():HasMany
    {
        return $this->hasMany(Req::class);
    }
}
