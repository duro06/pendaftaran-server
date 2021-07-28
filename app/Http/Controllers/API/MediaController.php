<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $daftar=Pendaftaran::get();
        return response()->json($daftar,200);
    }

    
    public function upload_image(Request $request)
    {
        $image='';
        $media=Media::find($request->id);
        if($request->hasFile('image')) {
            $request->validate([
                'image'=>'required|image|mimes:jpeg,png,jpg'
            ]);
            $path = $request->file('image')->store('photo', 'public');
            $image=$path;
        }
        if(is_null($media)){
            $media=Media::create([
                'name'=>$request->name,
                'user_id'=>$request->user_id,
                'type_id'=>$request->type_id,
                'path'=>$image,
            ]);
            $old_path = '$media->path';
        }else{
            $old_path = $media->path;
            Storage::delete('public/'.$old_path);
            $media->update([
                'name'=>$request->name,
                'user_id'=>$request->user_id,
                'type_id'=>$request->type_id,
                'path'=>$image
            ]);
        }


        
        // if($request->hasFile('image')) {
        //     $request->validate([
        //         'image'=>'required|image|mimes:jpeg,png,jpg'
        //     ]);
        //     $path = $request->file('image')->store('photo', 'public');
        //     $media->path = $path; 
            
        // }
       
        // if ($media->save()) {
        //     return response()->json($media,200);
        // } else {
        //     return response()->json([
        //         'message'       => 'Error on Updated',
        //         'status_code'   => 500
        //     ],500);
        // } 
        return response()->json([
            'image'=>$image,
            'old_path'=>$old_path,
            'media'=>$media,
            'request'=>$request->all()
        ],200);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        //
    }
}
