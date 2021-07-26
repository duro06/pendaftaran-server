<?php

namespace App\Http\Controllers\API;

use App\Models\Pendaftar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerkasController extends Controller
{
    public function get_all(){
        $pendaftar=Pendaftar::get();
        $pendaftar->load('user.bio');
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
}
