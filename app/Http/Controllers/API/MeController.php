<?php

namespace App\Http\Controllers\API;

use\App\Models\User;

use App\Http\Controllers\Controller;

use App\Http\Controllers\API\BerkasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MeController extends Controller
{
    
    public function update(Request $request, User $user)
    { 
        if ($user) {
            $user->notelp = $request->notelp;
            // $user->nowhatsapp = $request->nowhatsapp;
            $user->alamat = $request->alamat;
            $user->provinsi = $request->provinsi;
            $user->kota = $request->kota;
            if ($user->save()) {                
            (new BerkasController)->keteranganPendaftar();
                return response()->json($user,200);
            } else {
                return response()->json([
                    'status'       => 'Error on Updated',
                    'status_code'   => 500
                ],500);
            } 
        } else {
            return response()->json([
                'status'       => 'User tidak ditemukan',
                'status_code'   => 500
            ],500);
        }
       
    }

    
    public function upload_image(Request $request, User $user){

        
        $old_path = $user->avatar;
        Storage::delete('public/'.$old_path);
        if($request->hasFile('image')) {
            $request->validate([
                'image'=>'required|image|mimes:jpeg,png,jpg'
            ]);
            $path = $request->file('image')->store('images', 'public');
            $user->avatar = $path; 
            
        }
       
        if ($user->save()) {
            (new BerkasController)->keteranganPendaftar();
            return response()->json($user,200);
        } else {
            return response()->json([
                'message'       => 'Error on Updated',
                'status_code'   => 500
            ],500);
        } 
        // return response()->json($request->all(),200);

    }

    public function swToken(Request $request){
        
        $user = User::find($request->id);
        if($user->fcm_token != $request->token){
            DB::beginTransaction();
            try{
                $save=User::where('id',$request->id)->update(['fcm_token'=>$request->token]);

                DB::commit();
                return response()->json(['status'=>'sukses'], 200);
            }catch (\Exception $e){
            DB::rollback();
                return response()->json([
                    'status'=>'failse',
                    'message'=> $e->getMessage()
                ],400);
        }
        }else{
            return response()->json([                
                'message'=>'no data need to update',
            ],200);

        }
    }
}
