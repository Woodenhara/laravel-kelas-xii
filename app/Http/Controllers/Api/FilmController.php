<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\{
    StoreFilmRequest,
    UpdateFilmRequest,
};
use App\Interfaces\FilmRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\FilmResource;
use Illuminate\Support\Facades\DB;
// use App\Repositories\FilmRepository;
// use App\Interfaces\FilmRepositoryInterface;
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

        return ApiResponseClass::sendResponse(FilmResource::collection($data),'', 200);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmRequest $request)
    {
        //
        $posterPath = $request->file('poster')->store('public/images');

        $details = [
            'title'=> $request->title,
            'sinopsis'=> $request->sinopsis,
            'year'=> $request->year,
            'poster'=> str_replace('public/', 'storage/', $posterPath),
            'genre_id'=> $request->genre_id,
        ];

        DB::beginTransaction();
        try{
             $film = $this->filmRepositoryInterface->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse(new FilmResource($film),'Film Create Successful', 201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $film = $this->filmRepositoryInterface->getById($id);
        return ApiResponseClass::sendResponse(new FilmResource($film), '', 200);
    }

    /**
         * Show the form for editing the specified resource.
         */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmRequest $request, $id)
    {
        //
        $posterPath = $request->file('poster')->store('public/images');

        $updateDetails = $request->all();
        $updateDetails['poster'] = str_replace('public/', 'storage/', $posterPath);

        DB::beginTransaction();
        try{
             $film = $this->filmRepositoryInterface->update($updateDetails, $id);

             DB::commit();
             return ApiResponseClass::sendResponse('Film Update Successful','',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        DB::beginTransaction();
        try{
            $this->filmRepositoryInterface->delete($id);
            DB::commit();
            return ApiResponseClass::sendResponse('Film Delete Successful', 204);

        }catch(\Exception $ex){
            DB::rollBack();
            return ApiResponseClass::rollback($ex);
        }
    }

}
