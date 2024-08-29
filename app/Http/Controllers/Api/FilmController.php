<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FilmRepository;
use App\Classes\ApiResponseClass;
use App\Http\Resources\FilmResource;
use Illuminate\Support\Facades\DB;


class FilmController extends Controller
{
   private FilmRepository $filmRepositoryInterface;

   public function __construct(FilmRepository $filmRepositoryInterface)
   {
       $this->filmRepositoryInterface = $filmRepositoryInterface;
   }

    public function index()
    {
        $data = $this->filmRepositoryInterface->index();

        return ApiResponseClass::sendResponse(FilmResource::collection($data),'',200);
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
    public function store(Request $request)
    {
         $posterPath = $request->file('poster')->store('images');

        $details = [
            'title'     => $request->title,
            'sinopsis'  => $request->sinopsis,
            'poster'    => $posterPath,
            'year'      => $request->year,
            'genre_id'  => $request->genre_id,
        ];

        DB::beginTransaction();
        try{
            $film = $this->filmRepositoryInterface->store($details);
            DB::commit();
            return ApiResponseClass::sendResponse(new FilmResource($film), 'Film Create Successful', 200);
        } catch(\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }//
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $film = $this->filmRepositoryInterface->getById($id);
        return ApiResponseClass::sendResponse(new FilmResource($film),'', 200); //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}