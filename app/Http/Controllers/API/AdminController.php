<?php

namespace App\Http\Controllers\API;

use App\Models\Type;
use App\Models\Mapel;
use App\Models\User;

use App\Http\Controllers\API\Fcm\BroadcastMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller{
    public function testFcm(){
        $token=[];
        $user=Auth::user();
        $userToken=$user->fcm_token;
        array_push($token,$user->fcm_token);
        $message='Coba kang';
        // $test=BroadcastMessage::sendMessage($user->name, 'chat baru dari forum: '. $message, "forum/apem", $token);
        BroadcastMessage::sendMessage($user->name, 'chat baru dari forum: '. $message, "forum/apem", $token);
        return response()->json([
            'user'=>$user,
            // 'test'=>$test,
            'token'=>$token,
        ]);
    }
    public function add_mapel(Request $req){
        $req->validate([
                'name'=>'required',                
                'type_id'=>'required',                
            ]);
            
            $mapel=Mapel::create([
                'name'=>$req->name,
                'type_id'=>$req->type_id,
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
    public function edit_mapel(Request $req){
        $req->validate([
                'name'=>'required',                
                'id'=>'required',                
            ]);
        $mapel=Mapel::find($req->id);
        $mapel->name=$req->name;
        if($mapel->save()){
            return response()->json([
                'mapel'=>$mapel,                
            ],200);
        }else{
            
            return response()->json([
                'message'=>'failed',                
            ],500);
        }
    }
    public function delete_mapel(Request $req){
         $req->validate([
                'id'=>'required',                
            ]);
            $mapel=Mapel::find($req->id);
        if($mapel->delete()){
            return response()->json([
                'mapel'=>$mapel,                
            ],200);
        }else{
            
            return response()->json([
                'message'=>'failed',                
            ],500);
        }
    }
    public function add_type(Request $req){
        $req->validate([
                'name'=>'required',                
            ]);
            
            $type=Type::create([
                'name'=>$req->name,
            ]);
        if($type){
            return response()->json([
                'type'=>$type,                
            ],200);
        }else{
            
            return response()->json([
                'message'=>'failed',                
            ],500);
        }
    }
    public function edit_type(Request $req){
        $req->validate([
                'name'=>'required',                
                'id'=>'required',                
            ]);
        $type=Type::find($req->id);
        $type->name=$req->name;
        if($type->save()){
            return response()->json([
                'type'=>$type,                
            ],200);
        }else{
            
            return response()->json([
                'message'=>'failed',                
            ],500);
        }
    }
    public function delete_type(Request $req){
        $req->validate([
                'id'=>'required',                
            ]);
            $type=Type::find($req->id);
        if($type->delete()){
            return response()->json([
                'type'=>$type,                
            ],200);
        }else{
            
            return response()->json([
                'message'=>'failed',                
            ],500);
        }
    }
}