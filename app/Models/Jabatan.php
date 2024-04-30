<?php

namespace App\Models;
use App\Models\dosen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'jabatan';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'nama_jabatan', 'dosen_id', 'file', 'status']; 
    public function dosen():BelongsTo
    {
        return $this->belongsTo(dosen::class);
    }
}
