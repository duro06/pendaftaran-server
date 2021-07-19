<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

        protected $table = 'medias';
        protected $guarded = [];

    public function media()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }
}
