<?php

namespace App\Http\Controllers\API;



use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BerkasController;
use App\Http\Controllers\API\Fcm\BroadcastMessage;
use App\Models\Bio;
use App\Models\User;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();
        $bio=Bio::where('user_id',$user->id)->first();
        
        return response()->json([
            'data'=>$bio
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=User::find($request->user_id);
        $bio=Bio::where('user_id',$request->user_id)->first();
        $data='';
        if($user){
            if($bio){
                $data='Sudah ada';
            }else{
                Bio::create([
                    'user_id'=>$request->user_id
                ]);
                $data='Data Dibuat';
            }
        }

        return response()->json([
            'data'=>$data,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bio  $bio
     * @return \Illuminate\Http\Response
     */
    public function upload_image(Request $request, Bio $bio)
    {
        $old_path = $bio->path;
        Storage::delete('public/'.$old_path);
        if($request->hasFile('image')) {
            $request->validate([
                'image'=>'required|image|mimes:jpeg,png,jpg'
            ]);
            $path = $request->file('image')->store('photo', 'public');
            $bio->path = $path; 
            
        }
       
        if ($bio->save()) {
            (new BerkasController)->keteranganPendaftar();
            return response()->json($bio,200);
        } else {
            return response()->json([
                'message'       => 'Error on Updated',
                'status_code'   => 500
            ],500);
        } 
        // return response()->json($request->all(),200);

    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bio  $bio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bio $bio)
    {
        if ($bio) {
             $input = $request->all();
             $user=Auth::user();
             (new BroadcastMessage)->keteranganPendaftar($user);
            
            if ($bio->fill($input)->save()) {
                return response()->json([
                    'bio'=>$bio,
                    'input'=>$input],200);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bio  $bio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bio $bio)
    {
        //
    }
}
