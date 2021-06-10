<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    use HasFactory;
    
    protected $table = 'mapels';
    protected $guarded = [];

    public function mapel()
    {
        // return $this->hasOne(nilai::class, 'id', 'mapel_id');
        return $this->hasMany(Nilai::class, 'mapel_id', 'id');
    }
}
