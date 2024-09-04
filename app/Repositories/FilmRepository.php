<?php

namespace App\Repositories;
use App\Models\Film;
use App\Interfaces\FilmRepositoryInterface;

class FilmRepository implements FilmRepositoryInterface
{
    public function index(){
        return Film::all();
    }
    public function store(array $data){
        return Film::create($data);
     }
     public function getById($id)
     {
        return film::find($id);
     }
     
}