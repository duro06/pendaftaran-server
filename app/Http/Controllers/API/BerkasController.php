<?php

namespace App\Http\Controllers\API;

use App\Models\Pendaftar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BerkasController extends Controller
{
    public function get_all(){
        $pendaftar=Pendaftar::get();
        $pendaftar->load('user.bio');
        $pendaftar->load('statusby');
        // $pendaftar->load('bio');
        return response()->json($pendaftar,200);
    }
    public function get_by_id(){
        $pendaftar=Pendaftar::find(request()->id);
        if($pendaftar->status<1){
            $pendaftar->status=1;
            $pendaftar->save();
        }
        $pendaftar->load('user.bio');
        $pendaftar->load('nilai.mapel');
        $pendaftar->load('statusby');
        $pendaftar->load('media');
        return response()->json($pendaftar,200);
    }

    public function status_change(Request $request){
        $user=Auth::user();
        $pendaftar=Pendaftar::find($request->id);
        $pendaftar->status=$request->status;
        $pendaftar->status_by=$user->id;

            // return response()->json(['sukses'=>$pendaftar],200);
        if($pendaftar->save()){
            
                return response()->json('sukses',200);
        }else{
            return response()->json('failed',500);

        }
    }
}
