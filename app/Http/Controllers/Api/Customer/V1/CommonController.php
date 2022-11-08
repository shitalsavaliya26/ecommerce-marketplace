<?php

namespace App\Http\Controllers\Api\Customer\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\State;

class CommonController extends Controller
{
    /* get states */
    public function getStates(Request $request)
    {
        $state = State::select('id', 'name')->get();
        if ($state->count() > 0) {
            return response()->json(['success' => true, 'data' => $state, 'message' => 'All state fatched successfully.', 'code' => 200], 200);
        }
        return response()->json(['success' => true, 'message' => 'No state found in the system.', 'code' => 200], 200);
    }

}
