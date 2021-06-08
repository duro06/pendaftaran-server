<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    use HasFactory;
    
    protected $table = 'nilais';
    protected $guarded = [];

    public function nilai()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
