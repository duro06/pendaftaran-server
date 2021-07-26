<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $table = 'pendaftars';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'user_id', 'id');
    }

    public function statusby()
    {
        return $this->hasOne(User::class, 'id', 'status_by');
    }
    public function media()
    {
        return $this->hasMany(Media::class, 'user_id', 'id');
    }

}
