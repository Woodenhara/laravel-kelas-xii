<?php

namespace App\Repositories;
use App\Models\Film;
use App\Interfaces\FilmRepositoryInterface;
class FilmRepository implements FilmRepositoryInterface
{
    public function index(){
        return Film::all();
    }

    public function getByid($id)
    {
        return Film::with(['peran', 'kritik'])->findOrFail($id);
    }

    public function store(array $data){
       return Film::create($data);
    }
}


