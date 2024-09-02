<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\Peran;
use App\Models\Kritik;

class Film extends Model
{
    use HasFactory;
    protected $table = 'films';
    protected $fillable = ['title','sinopsis','year','poster','genre_id'];

    public function peran()
    {
        return $this->hasMany(Peran::class, 'film_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }
    

    public function kritiks()
    {
        return $this->hasMany(kritik::class, 'film_id');
    }

}
