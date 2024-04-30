<?php

namespace App\Models;

use App\Models\dosen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Serkom extends Model
{
    use HasFactory;
    protected $table = 'serkom';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'file', 'dosen_id', 'bidang', 'penerbit', 'tgl_terbit', 'status']; 
    public function dosen():BelongsTo
    {
        return $this->BelongsTo(dosen::class);
    }
}
