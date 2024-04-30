<?php

namespace App\Models;

use App\Models\dosen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataAjar extends Model
{
    use HasFactory;
    protected $table = 'data_ajar';
    protected $primarykey = 'id';
    protected $fillable = ['id', 'sks'. 'kelas', 'thn_ajar', 'matkul_id', 'dosen_id','file', 'status']; 
    
    public function dosen():BelongsTo
    {
        return $this->BelongsTo(dosen::class);
    }

}
