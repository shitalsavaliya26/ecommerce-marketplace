<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transactionhistoriesagent;
use App\User;
use Auth;
use App\Role;
class AgentController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /* agent commission report */
    public function commission(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();

        if($user->role_id == 15){
            $comissionhistory = Transactionhistoriesstaff::select('id', 'order_id', 'user_id', 'amount', 'created_at', 'transaction_for', 'status')
            ->where('user_id', '!=', '1')
            ->whereNotIn('status', ['pending', 'reject']);
        }else{
            $comissionhistory = Transactionhistoriesagent::select('id', 'order_id', 'user_id', 'amount', 'created_at', 'transaction_for', 'status')
            ->where('user_id', '!=', '1')
            ->whereNotIn('status', ['pending', 'reject']);
        }

        $comissionhistory = $comissionhistory->where('user_id', $user->id);
        
        $comissionhistory =  $comissionhistory->orderBy('created_at', 'DESC')->paginate(10);
        $agents = User::whereNotIn('role_id', ['1', '7'])->where('is_deleted', '0')->get();

        return view('profile.commissionhistory')->with('comissionhistory', $comissionhistory)->with('agents', $agents)->with($data);
        
    }

    /* network */
    public function network(Request $request)
    {
            $user = $this->user;
        $userroles = Role::select('id')->where('id','>=',1)->pluck('id')->toArray();
        $users = User::where(function($query) use ($user){
            $query->where('id',$user->id);
        })->whereNotIn("role_id", [1, 8, 16])->get();

        $allusers = User::pluck('name','id')->all();

        $roles = Role::where("id", '>', $user->role_id)->whereNotIn("id", [1, 7, 8, 16])->get();
        $colors = $this->getColorCodes();
        // dd( $users);
        //             $user = User::where('role_id','=','1')->first();
        // $userroles=Role::select('id')->where('id','>=',7)->get();
        //     $users = User::where('parent_id', '=', 0)->whereNotIn("role_id", $userroles)->get();
        //     $allusers = User::pluck('name','id')->all();
            // dd($users);
        return view('profile.network')
        ->with('usersJson', $users)
        ->with('colors', $colors)
        ->with('roles', $roles);
    }

    private function getColorCodes()
    {
        $users = User::where("role_id", 6)->get();
        $colors = [];
        foreach ($users as $user) {
            if ($user->rank_id == 1) {
                $colors[$user->id] = ["color" =>  "pl"];
            } else if ($user->rank_id == 2) {
                $colors[$user->id] = ["color" =>  "pl"];
            } else if ($user->rank_id == 3) {
                $colors[$user->id] = ["color" =>  "pl"];
            } else {
                $colors[$user->id] = ["color" =>  "pl"];
            }
        }
        return $colors;
    }
}
