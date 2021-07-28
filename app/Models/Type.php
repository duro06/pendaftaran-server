<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    
    protected $table = 'types';
    protected $guarded = [];

    public function mapel()
    {
        // return $this->hasOne(nilai::class, 'id', 'mapel_id');
        return $this->hasMany(Mapel::class, 'type_id', 'id');
    }
    
    public function media()
    {
        // return $this->hasOne(nilai::class, 'id', 'mapel_id');
        return $this->hasOne(Media::class, 'type_id', 'id');
    }
    public function user()
    {
        // return $this->hasOne(nilai::class, 'id', 'mapel_id');
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
