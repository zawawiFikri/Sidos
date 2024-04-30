<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\dosen;
use App\Models\admin;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'id',
        'nik',
        'jenis_kelamin',
        'alamat',
        'tgl_lahir',
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function roles(): BelongsTo {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function dosen(): HasOne
    {
        return $this->hasOne(dosen::class, 'user_id');
    }

    public function admin(): HasOne
    {
        return $this->hasOne(admin::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->roles->role_name == 'admin';
    }

    public function isDosen()
    {
        return $this->roles->role_name == 'dosen';
    }
 
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
