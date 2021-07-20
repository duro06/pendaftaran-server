<?php

namespace App\Http\Controllers\API;

use App\Models\Nilai;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Media;
use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NilaiController extends Controller
{
    
    public function index()
    {
        $mapel=Mapel::get();
        return response()->json($mapel,200);
    }
    public function type()
    {
        $type=Type::get();
        $type->load('media');
        return response()->json($type,200);
    }

    public function nilai_by(){
        $user_id=request()->user_id;
        $type_id=request()->type_id;
        $nilai=Nilai::where([
            ['user_id','=',$user_id],
            ['type_id','=',$type_id],
        ])->get();
        $nilai->load('mapel');
        return response()->json($nilai,200);
    }

    public function store(Request $request){
        $request->validate([
                'user_id'=>'required',
                'mapel_id'=>'required',
                'type_id'=>'required',
                'nilai'=>'required'
            ]);
            $mapel=Nilai::create([
                'user_id'=>$request->user_id,
                'mapel_id'=>$request->mapel_id,
                'type_id'=>$request->type_id,
                'nilai'=>$request->nilai
            ]);
        if($mapel){
            return response()->json([
                'mapel'=>$mapel,
                
            ],200);
        }else{
            
            return response()->json([
                'message'=>'failed',
                
            ],500);
        }
    }

    public function update(Request $request, Nilai $nilai){
        $nilai->nilai=$request->nilai;
        if($nilai->save()){
            return response()->json('success',200);
        }else{
            return response()->json('failed',500);

        }
    }


    public function upload_image(Request $request, Media $media)
    {
        $old_path = $media->path;
        Storage::delete('public/'.$old_path);
        if($request->hasFile('image')) {
            $request->validate([
                'image'=>'required|image|mimes:jpeg,png,jpg'
            ]);
            $path = $request->file('image')->store('photo', 'public');
            $media->path = $path; 
            
        }
       
        if ($media->save()) {
            return response()->json($media,200);
        } else {
            return response()->json([
                'message'       => 'Error on Updated',
                'status_code'   => 500
            ],500);
        } 
        // return response()->json($request->all(),200);

    }

}
