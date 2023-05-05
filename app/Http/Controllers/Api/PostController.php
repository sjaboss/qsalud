<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    
public function __construct()
{
    $this->middleware('auth:api')->except(['index', 'show']); //Javi aca estamos protegiendo todos los metodos menos estos index y show que no hacen falta
}

    public function index()
    {
        $post = Post::included()
            ->filter() // Javi con este filtramos
            ->sort() // Javi aca lo ordenamos desc o asc
            ->getOrPaginate(); // Javi paginacion
        // ->get(); // Javi con el get se cre la coleccion
      
        return PostResource::collection($post);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    /*     return auth()->user(); */
        
       $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts',
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
          
        ]);

        $user = auth()->user();
        $data['user_id'] = $user->id;
        
        $post = Post::create($data);
        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::included()->findOrfail($id);
        return  PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data =  $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts,slug,' . $post->id,
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);
        $user = auth()->user();
        $data['user_id'] = $user->id;
        $post->update($data);

        return  PostResource::make($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return  PostResource::make($post);
    }
}
