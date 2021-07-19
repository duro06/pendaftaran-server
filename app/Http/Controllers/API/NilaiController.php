<?php

namespace App\Http\Controllers\API;

use App\Models\Nilai;
use App\Models\Mapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    
    public function index()
    {
        $mapel=Mapel::get();
        return response()->json($mapel,200);
    }

}
