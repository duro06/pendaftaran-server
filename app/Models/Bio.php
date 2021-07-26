<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    use HasFactory;
    
    protected $table = 'biodatas';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'user_id', 'id');
    }
    public function media()
    {
        return $this->hasMany(Media::class, 'user_id', 'id');
    }
}
