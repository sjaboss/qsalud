<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Image;
use App\Traits\ApiTrait; 

class Post extends Model
{
    use HasFactory ,ApiTrait ; 


    const BORRADOR = 1;
    const PUBLICADO = 2;

    protected $fillable =['name','slug','extract','body','status','category_id','user_id'];

    //relacion uno a muchos INVERSA
    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    public function category()
    {
        return  $this->belongsTo(Category::class);
    }

    //relacion de muchos a muchos
    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Relacion uno a muchos polimorfica
    public function image()
    {
        return $this->morphMany(Image::class,'imageable');
    }
}
