<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\{
    StoreFilmRequest,
    UpdateFilmRequest
};
use App\Interfaces\FilmRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\FilmResource;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    private FilmRepositoryInterface $FilmRepositoryInterfaces;

    public function __construct(FilmRepositoryInterface $FilmRepositoryInterfaces)
    {
        $this->FilmRepositoryInterfaces = $FilmRepositoryInterfaces;
    }

    public function index()
    {
        $data = $this->FilmRepositoryInterfaces->index();
        return ApiResponseClass::sendResponse(FilmResource::collection($data), '', 200);
    }

    public function store(StoreFilmRequest $request)
    {
        $posterPath = $request->file('poster')->store('images');

        $details =[
            'id' => $request->id,
            'title' => $request->title,
            'sinopsis' => $request->sinopsis,
            'poster' => $posterPath,
            'year' => $request->year,
            'genre_id' => $request->genre_id,


        ];
        DB::beginTransaction();
        try{
             $Film = $this->FilmRepositoryInterfaces->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse(new FilmResource($Film),'Film Create Successful',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }  
    }


    public function show($id)
    {
        $Film = $this->FilmRepositoryInterfaces->getById($id);

        $Film['kritiks'] = $Film->kritik()->get();
        $Film['perans'] = $Film->peran()->get();
        return ApiResponseClass::sendResponse(new FilmResource($Film),'',200);
    }

    public function update(StoreFilmRequest $request, $id)
    {
        
    }

    public function destroy(string $id)
    {
       
    }
}