<?php

namespace App\Models;

use App\Models\User;
use App\Models\Serkom;
use App\Models\Ijazah;
use App\Models\DataAjar;
use App\Models\Jabatan;
use App\Models\Req;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $fillable = [
        'nidn',
        'serdos',
        'user_id',
        'foto_profil',
    ];

    public function user():BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id');
    }

    public function serkom():HasMany
    {
        return $this->HasMany(Serkom::class);
    }

    public function ijazah():HasMany
    {
        return $this->HasMany(Ijazah::class);
    }

    public function data_ajar():HasMany
    {
        return $this->HasMany(DataAjar::class);
    }

    public function jabatan():HasMany
    {
        return $this->hasMany(Jabatan::class);
    }
    
    public function request():HasMany
    {
        return $this->hasMany(Req::class);
    }
}
