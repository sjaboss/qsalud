<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PostResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /*   return parent::toArray($request); */ //javi aca muestra todo 
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'post' => PostResource::collection($this->whenLoaded('post'))
        ]; //Javi de esta manera vamos seleccionado lo que queremos mostrar

    }
}
