<?php

namespace App\Models;

use App\Models\dosen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Ijazah extends Model
{
    use HasFactory;
    protected $table = 'ijazah';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'institusi', 'program_study', 'gelar', 'tgl_lulus', 'file', 'status']; 
    public function dosen():BelongsTo
    {
        return $this->BelongsTo(dosen::class);
    }
}
