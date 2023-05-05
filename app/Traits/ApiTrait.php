<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ApiTrait
{
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) { //javi aca revisamos que nos devuelva info con los parametros de carga. si no es asi no hace nada 
            return;
        }
        $relations = explode(',', request('included'));/* Javi aca armamos un array y le decimos que lo separamos con comas */
        $allowIncluded = collect($this->allowIncluded); //Javi aca armamos una coleccion del array
        foreach ($relations as $key => $relationship) { //Javi aca recorremos y obtenemos tambien el indice $key
            if (!$allowIncluded->contains($relationship)) { //Javi si el elemento no se encuentra dentro del array lo vamos a eliminar unset()
                unset($relations[$key]); // javi aca le retornamos el indice $key
            }
        }
        $query->with($relations);
    }

    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) { //javi aca revisamos que nos devuelva info con los parametros de carga. si no es asi no hace nada 
            return;
        }
        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE', '%' . $value . '%'); //javi aca usamos like para buscar por parte de palabras
            }
        }
    }

    public function scopeSort(Builder $query)
    {

        if (empty($this->allowSort) || empty(request('sort'))) { //javi aca revisamos que nos devuelva info con los parametros de carga. si no es asi no hace nada 
            return;
        }

        $sortFields = explode(',', request('sort'));/* Javi aca armamos un array y le decimos que lo separamos con comas */
        $allowSort = collect($this->allowSort); //Javi aca armamos una coleccion del array

        foreach ($sortFields as  $sortField) {

            $direction = 'ASC';

            if (substr($sortField, 0, 1) == '-') {
                $direction = 'DESC';
                $sortField = substr($sortField, 1);
            }

            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
    }

    public function scopeGetOrPaginate(Builder $query)
    {

        if (request('perPage')) { //Javi aca revisamos que estamos mandando el perPeg por la url
            $perPage = intval(request('perPage')); //Javi aca tranformamos en numero la url

            if ($perPage) {
                return $query->paginate($perPage); # code...
            }
        }
        return $query->get();
    }
}
