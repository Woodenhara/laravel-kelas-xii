<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'title' => $this->title,
            'poster' => $this->poster,
            'year' => $this->year,
            'sinopsis' => $this->sinopsis,
            'genre' => $this->genre_id,
            'komentar'=> $this->kritiks->pluck('comment'),   
            'actor'=>$this -> perans->map(function($peran){
                return[
                    'actor'=>$peran->actor,
                    'cast'=>$peran->cast->name,
                ];
            }),
        ];
    }
}