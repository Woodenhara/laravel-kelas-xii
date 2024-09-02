<?php

namespace App\Interfaces;
interface FilmRepositoryInterFace
{
    //
    public function index();
    public function getById($id);
    public function store(array $details);

   

}