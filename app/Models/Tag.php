<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Traits\ApiTrait;

class Tag extends Model
{
    use HasFactory ,ApiTrait ;

    //relacion de muchos a muchos

    public function post()
    {
        return  $this->belongsToMany(Post::class);
    }
}
