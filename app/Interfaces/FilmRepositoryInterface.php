<?php

namespace App\Interfaces;

interface FilmRepositoryInterface
{
    public function index();
    public function getById($id);
    public function store(array $data);
}
