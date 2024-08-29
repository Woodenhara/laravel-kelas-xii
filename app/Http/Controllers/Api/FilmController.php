<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\{
    StoreFilmRequest,
    UpdateFilmRequest,
};
use App\Interfaces\FilmRepositoryInterFace;
use App\Classes\ApiResponseClass;
use App\Http\Resources\FilmResource;
use Illuminate\Support\Facades\DB;
use Exception;


class FilmController extends Controller
{
    private FilmRepositoryInterFace $FilmRepositoryInterFace;

    public function __construct(FilmRepositoryInterFace $FilmRepositoryInterFace)
    {
        $this->FilmRepositoryInterFace = $FilmRepositoryInterFace;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->FilmRepositoryInterFace->index();
        return ApiResponseClass::sendResponse(FilmResource::collection($data), '', 200);
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
        $posterPath = $request->file('poster')->store('images');

        $details =[
            'id' => $request->id,
            'title' => $request->title,
            'sinopsis' => $request->sinopsis,
            'poster' => $posterPath,
            'year' => $request->year,
            'genre_id' => $request->genre_id
        ];
        DB::beginTransaction();
        try{
             $Film = $this->FilmRepositoryInterFace->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse(new FilmResource($Film),'Film Create Successful',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Film = $this->FilmRepositoryInterFace->getById($id);

        $Film['kritiks'] = $Film->kritiks()->get();
        $Film['perans'] = $Film->peran()->get();

        return ApiResponseClass::sendResponse(new FilmResource($Film),'',200);
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
        // $updateDetails = [
        //     'title'     => $request->title,
        //     'sinopsis'  => $request->sinopsis,
        //     'poster'    => 'storage/images/h6.jpg', // Consider allowing dynamic poster updates
        //     'year'      => $request->year,
        //     'genre_id'  => $request->genre_id,
        // ];

        // DB::beginTransaction();
        // try {
        //     $film = $this->filmRepositoryInterface->update($updateDetails, $id);
        //     DB::commit();
        //     return ApiResponseClass::sendResponse('Film Update Successful', 201);
        // } catch (Exception $ex) {
        //     DB::rollBack(); // Make sure to rollback the transaction
        //     return ApiResponseClass::rollback($ex);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->filmRepositoryInterface->delete($id);
        // return ApiResponseClass::sendResponse('Film Delete Successful', 204);
    }
}
