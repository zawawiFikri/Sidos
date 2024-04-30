<?php

namespace App\Models;

use App\Models\dosen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Req extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'request';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'file', 'dosen_id', 'jenis_req', 'isi_req', 'status']; 
    public function dosen():BelongsTo
    {
        return $this->BelongsTo(dosen::class);
    }
}
