<?php

namespace App\Http\Controllers\API;

use App\Models\Sekolah;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sekolah=Sekolah::find(1);
        
        return response()->json($sekolah,200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $sekolah=Sekolah::where('id',1)->first();
        $result=$request->all();
        $sekolah=Sekolah::updateOrCreate(
            ['id'=>1],
            $result
        );

        return response()->json($sekolah,200);
    }

    public function upload_image(Request $request, Sekolah $sekolah){

        
        $old_path = $sekolah->path;
        Storage::delete('public/'.$old_path);
        if($request->hasFile('image')) {
            $request->validate([
                'image'=>'required|image|mimes:jpeg,png,jpg'
            ]);
            $path = $request->file('image')->store('sekolah', 'public');
            $sekolah->path = $path; 
            
        }
       
        if ($sekolah->save()) {
            return response()->json($sekolah,200);
        } else {
            return response()->json([
                'message'       => 'Error on Updated',
                'status_code'   => 500
            ],500);
        } 
        // return response()->json($request->all(),200);

    }
}
