<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
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

    public function peserta()
    {
        $daftar=Pendaftar::get();
        $daftar->load('user.bio');
        return response()->json($daftar,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function daftar_peserta(Request $request)
    {
        $request->validate([
                'pendaftaran_id'=>'required',
            ]);

        $user=Auth::user();
        $pendaftar=Pendaftar::create([
            'name'=>$user->name,
            'user_id'=>$user->id,
            'pendaftaran_id'=>$request->pendaftaran_id,
            'status'=>0
        ]);

        if($pendaftar){
            return response()->json('success',200);
        }else{
            return response()->json('failed',500);

        }
    }

    // admin

    public function add_pendaftaran(Request $request){
        $request->validate([
                'name'=>'required',
                'start'=>'required',
                'stop'=>'required',
                'status'=>'required',
            ]);
            $pendaftaran=Pendaftaran::create([
            'name'=>$request->name,
            'start'=>$request->start,
            'stop'=>$request->stop,
            'status'=>$request->status
        ]);
        if($pendaftaran){
            return response()->json('success',200);
        }else{
            return response()->json('failed',500);

        }
    }
    public function edit_pendaftaran(Request $req){
        $req->validate([
            'id'=>'required'
        ]);
        $pendaftaran=Pendaftaran::find($req->id);

        $pendaftaran->name=$req->name;
        $pendaftaran->status=$req->status;
    
    if($pendaftaran->save()){
        return response()->json('success',200);
    }else{
        return response()->json('failed',500);
    
    }
    }
    public function hapus_pendaftaran(Request $req){
        $req->validate([
            'id'=>'required'
        ]);
        $pendaftaran=Pendaftaran::find($req->id)->delete();
        return response()->json('success',200);
    //     if($pendaftaran->trashed()){
    //     }else{
    //         return response()->json(['message'=>'failed','data'=>$pendaftaran],500);
        
    // }
}
public function restore_pendaftaran(Request $req){
        $req->validate([
            'id'=>'required'
        ]);
        $pendaftaran=Pendaftaran::onlyTrashed()->where('id',$req->id)->first();
        if($pendaftaran->restore()){
            return response()->json('success',200);
        }else{
            return response()->json(['data'=>$pendaftaran,'id'=>$req->id],500);
            
        }

    }
    public function inactive_pendaftaran(){
        $pendaftaran=Pendaftaran::onlyTrashed()->get();
        
        return response()->json($pendaftaran,200);
    }
}
