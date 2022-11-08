<?php

namespace App\Http\Controllers\Api\Agent\V1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Response;

class AgnetController extends Controller
{
    /* get all agent */
    public function getAgents(Request $request)
    {
        $customerrole = ['7', '1'];
        $agents = User::whereNotIn('role_id', $customerrole)->where('role_id', '<', '7')
            ->where('is_deleted', 0)->orderBy('id', 'DESC')->get()
            ->makeHidden(['device_token', 'login_token', 'device_type', 'created_at', 'updated_at', 'is_verify']);

        if ($agents && count($agents) > 0) {
            return Response::json(['success' => true, "payload" => array("agents" => $agents), 'message' => 'All agent', "code" => 200], 200);
        } else {
            return Response::json(['success' => false, 'message' => 'No Agent found!', "code" => 401], 401);
        }
    }
}
