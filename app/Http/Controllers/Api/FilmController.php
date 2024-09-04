<?php

namespace App\Http\Controllers\Api;

use App\Models\Product; 
use App\Interfaces\FilmRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\FilmResource;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreFilmRequest;

class FilmController extends Controller
{
    private FilmRepositoryInterface $filmRepositoryInterface;
    
    public function __construct(FilmRepositoryInterface $filmRepositoryInterface)
    {
        $this->filmRepositoryInterface = $filmRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->filmRepositoryInterface->index();

        return ApiResponseClass::sendResponse(FilmResource::collection($data),'',200);
    }
    public function store(StoreFilmRequest $request){
        $posterPath = $request->file('poster')->store('public/images');
        $details =[
            'title' => $request-> title,
            'sinopsis' => $request -> sinopsis,
            'year' => $request -> year,
            'genre_id' => $request -> genre_id,
            'poster' => str_replace('public/', 'storage/', $posterPath)
        ];
        DB::beginTransaction();
        try{
            $film = $this->filmRepositoryInterface->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new FilmResource($film), 'film create succesfull', 201);
        } catch(Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
        
    }
    public function show(string $id)
    {
        $data = $this->filmRepositoryInterface->getById($id);
        return ApiResponseClass::sendResponse(new FilmResource($data), '', 200);

        
    }

}
