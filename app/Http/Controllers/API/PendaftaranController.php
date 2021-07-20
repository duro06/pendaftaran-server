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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        //
    }
}
