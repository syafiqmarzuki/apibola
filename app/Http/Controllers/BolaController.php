<?php

namespace App\Http\Controllers;

use App\Models\Bola;
use App\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BolaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response() -> json(Response::transform(Bola::get(), "ok" , 1), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $rules = [
        //     'name' => 'required',
        //     'description' => 'required',
        //     'image' => 'required'
        // ];

        // $validator = Validator::make($request->all(), $rules);
        // if($validator->fails()){
        //     return response() -> json(array(
        //         'message' => 'check your request again. desc must be 10 char or more and form must be filled', 'status' => false), 400);
        // }else{
        //     $image = $request->file('image');
        //     $extension = $image->getClientOriginalExtension();
        //     Storage::disk('public')->put($image->getFilename().'.'.$extension,  File::get($image));
        //     $bola = new Bola();
        //     $bola->name = $request->name;
        //     $bola->description = $request->description;
        //     $bola->image = "uploads/".$image->getFilename().'.'.$extension;
        //     $bola->save();

        //     return response()->json(
        //         Response::transform(
        //             $bola, 'successfully created', true
        //         ), 201);
        // }

        $this->validate($request , [
        'name' => 'required',
        'description' => 'required',
        'image' => 'required'
        ]);

        $image= $request->file('image')->store('bola');

        $bola = Bola::create([
        'name' => $request->name,
        'description' => $request->description,
        'image' => $image
        ]);

        return response()->json([
        'message' => 'berhasil',
        'status' => 1,
        'data' => $bola
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bola  $bola
     * @return \Illuminate\Http\Response
     */
    public function show(Bola $bola , $id)
    {
        $bola = Bola::find($id);
        if (is_null($bola)) {
            return response()->json(array('message'=>'
                record not found', 'status'=>false),201);
        }
        return response() -> json(Response::transform($bola,"found", true), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bola  $bola
     * @return \Illuminate\Http\Response
     */
    public function edit(Bola $bola)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bola  $bola
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bola $bola)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bola  $bola
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bola = Bola::find($id);
        if(is_null($bola)){
            return response() -> json(array('message'=>'cannot delete because record not found', 'status'=>0),200);
        }
        Bola::destroy($id);
        return response() -> json(array('message'=>'succesfully deleted', 'status' => 1), 200);
    }

    public function search(Request $request){
        $query = $request->search;
        $bola = Bola::where('name','LIKE','%'.$query.'%')->get();
        if(sizeof($bola) > 0){
            return response() -> json(Response::transform($bola,"Has found", 1), 200);
        }else{
            return response() -> json(array('message'=>'No record found', 'status' => 0), 200);
        }
    }
}
