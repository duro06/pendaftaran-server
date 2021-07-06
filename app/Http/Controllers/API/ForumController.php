<?php

namespace App\Http\Controllers\API;

use App\Models\Forum;
use App\Models\User;
use App\Http\Controllers\Controller;
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
        if($request->jenjang_id){
            $forum=Forum::create([
                'user_id'=>$user->id,
                'user_name'=>$user->name,
                'jenjang_id'=>$request->jenjang_id,
                'message'=>$request->message,
            ]);
            $forum_user=Forum::select('user_id')->where('jenjang_id',$request->jenjang_id)->distinct()->get();
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
            if(count($token)>=1){
                BroadcastMessage::sendMessage($user->name, 'chat baru dari forum: '. $request->message, "forum/".$request->lelang_id, $token);
            }
            $data=['data'=>$request->message];
            return response()->json([
                'chat'=>$data,
            ],200);
        } else {
            return response()->json([
                'message'       => 'Error',
                'status_code'   => 500
            ],500);
        }
    }

    public function get_chat(){
        $jenjang=request()->jenjang_id;
        if($jenjang){
            $pesan=Forum::where('jenjang_id',$jenjang)
            ->orderBy('created_at','ASC')
            ->paginate(20);
        }else{
            $pesan=Forum::orderBy('created_at','ASC')
            ->paginate(20);
        }

        return response()->json([
            'chat'=>$pesan
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
