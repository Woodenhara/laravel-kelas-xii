<?php

namespace App\Repositories;

use App\Models\Film;
use App\Interfaces\FilmRepositoryInterFace;

class FilmRepository implements FilmRepositoryInterFace
{
    /**
     * Create a new class instance.
     */

    public function index(){
        return Film::all();
    }

    public function getById($id){
        return Film::with('peran.cast')->findOrFail($id);
     }
 

    public function store(array $details){
        return Film::create($details);
     }

   
}