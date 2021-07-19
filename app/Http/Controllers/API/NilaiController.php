<?php

namespace App\Http\Controllers\API;

use App\Models\Nilai;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Media;
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

    public function store(Request $request){
        $mapel=Nilai::find($request->nilai_id);
        $user=User::find($request->id);
        $data='';
        $return=$request->all();

        if(!empty($mapel)){
            $data='ada data';
            $mapel->nilai=$request->nilai;
            $mapel->save();
        }else{
            $data='tidak ada data';
            $mapel=Nilai::create([
                'user_id'=>$request->id,
                'mapel_id'=>$request->mapel_id,
                'nilai'=>$request->nilai
            ]);
            $media=Media::create([
                'user_id'=>$request->id,
                'mapel_id'=>$request->mapel_id,
                'name'=>$request->mapel_name,
                
            ]);
        }
        $check=empty($mapel);
        return response()->json([
            'data'=>$data,
            'user'=>$user,
            'return'=>$return,
            'mapel'=>$mapel,
            'check'=>$check
        ]);
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
