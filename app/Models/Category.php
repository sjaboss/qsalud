<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use App\Traits\ApiTrait; 

class Category extends Model
{
    use HasFactory ,ApiTrait ; 

    protected $fillable = ['name', 'slug'];
    protected $allowIncluded = ['post', 'post.user'];
    protected $allowFilter = ['id', 'name', 'slug']; // Javi aca se le dice por cual de los campos lo vamos a filtrar
    protected $allowSort = ['id', 'name', 'slug']; // Javi aca se le dice por cual de los campos lo vamos a orfenar

    //relacion uno a muchos
    public function post()
    {
        return $this->hasMany(Post::class);
    }

  
}