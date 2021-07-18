<?php

namespace App\Http\Controllers\API;

use App\Models\Forum;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Fcm\BroadcastMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function add_message(Request $request){
        $user=Auth::user();
        $all=[];
        $token=[];
        $finally=[];
        if($request->sekolah_id){
            $forum=Forum::create([
                'user_id'=>$user->id,
                'user_name'=>$user->name,
                'sekolah_id'=>$request->sekolah_id,
                'message'=>$request->message,
            ]);
            $forum_user=Forum::select('user_id')->where('sekolah_id',$request->sekolah_id)->distinct()->get();
            foreach ($forum_user as $key) {
                array_push($all,$key->user_id);
            }
            $finally=array_unique($all);
            foreach($finally as $key){
                $get=User::find($key)->fcm_token;
                array_push($token,$get);
            }
        }else{
            $forum=Forum::create([
                'user_id'=>$user->id,
                'user_name'=>$user->name,
                'message'=>$request->message,
            ]);
            $token=User::find($user->id)->pluck('fcm_token')->toArray();

        }
        if ($forum) {
            // $pesan=Forum::where('lelang_id',$request->lelang_id)->get();
            if(count($token)>=1 && $token!=null){
                BroadcastMessage::sendMessage($user->name, 'chat baru dari forum: '. $request->message, "forum/".$request->lelang_id, $token);
            }
            $data=['data'=>$request->message];
            return response()->json([
                'chat'=>$data,
                'token'=>$token,
                'Count token'=>count($token),
            ],200);
        } else {
            return response()->json([
                'message'       => 'Error',
                'status_code'   => 500
            ],500);
        }
    }

    public function get_chat(){
        $sekolah=request()->sekolah_id;
        if($sekolah){
            $pesan=Forum::where('sekolah_id',$sekolah)
            ->orderBy('created_at','DESC')
            ->paginate(20);
        }else{
            $pesan=Forum::orderBy('created_at','DESC')
            ->paginate(20);
        }
        
        return response()->json([
            'chat'=>$pesan
        ]);
    }
    
    public function get_user(){
        $sekolah=request()->sekolah_id;
        $users=[];
        if($sekolah){
            $user=Forum::select('user_id')->where('sekolah_id',$sekolah)->distinct()->get();
            foreach($user as $key){
                $get=User::find($key->user_id);
                array_push($users,$get);
            }
        }else{
            $user=Forum::select('user_id')->distinct()->get();
            foreach($user as $key){
                $get=User::find($key->user_id);
                array_push($users,$get);
            }
            
        }
        
        return response()->json([
            'user'=>$users
        ]);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
