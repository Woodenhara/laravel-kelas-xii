<?php

namespace App\Interfaces;

interface FilmRepositoryInterface
{
public function store(array $data);
   public function index(); //

   public function getById($id);
}
