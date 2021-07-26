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
        $pendaftar->load('user');
        return response()->json($pendaftar,200);
    }
    public function get_by_id(){
        $pendaftar=Pendaftar::find(request()->id);
        return response()->json($pendaftar,200);
    }
}
