<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SellerWithdrawRequest;
use Auth,DB,Validator,Response;
use App\Seller;
use App\Bank;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->actualuser = $this->user = Auth::user();
            $this->user = Seller::where('user_id',$this->user->id)->first();
            return $next($request);
        });
    }

    public function withdrawals(Request $request){
        $data = $request->all();
        $Withdraw = SellerWithdrawRequest::select('*');

        $where = [];
        if (isset($data['status']) && $data['status'] != '') {
            $where[] = ['status', '=', $data['status']];
        }
        if ($request->get('fromDate') && $request->get('fromDate') != '') {
            $where[] = ['created_at', ">=", date("Y-m-d H:i:s", strtotime($request->get('fromDate')))];
        }
        if ($request->get('toDate') && $request->get('toDate') != '') {
            $where[] = ['created_at', "<=", date("Y-m-d 23:59:59", strtotime($request->get('toDate')))];
        }
        // if ($request->get('agent') && $request->get('agent') != '') {
            $where[] = ['user_id', '=', $this->user->id];
        // }

        $Withdraw = $Withdraw->where($where);
        $totalAmount = $Withdraw->sum('amount');

        $Withdraw = $Withdraw->orderby(DB::raw('case when status= "pending" then 1 when status= "accept" then 2 when status= "reject" then 2 end'))
                            ->orderby('created_at', 'desc')
                            ->paginate(10)->appends($data);

        return view('seller.withdraw.requests', compact('Withdraw', 'totalAmount'))->with($data);
    }

    /* create new withdraw request */
    public function addWithdrawal(Request $request)
    {
        $banks = Bank::select('name', 'id')
                ->where('is_deleted', '0')
                ->get();

        return view('seller.withdraw.addrequest', compact('banks'));

    }

    /* store withdrawal */
    public function storeWithdrawal(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array(
                "amount" => "required|numeric",
                "account_number" => "required|numeric",
                "bank_id" => "required",
            ),
            [
                'amount.required' => trans('messages.amount.required'),
                'account_number.required' => trans('messages.account_number.required'),
                'account_number.numeric' => trans('messages.account_number.numeric'),
                'bank_id.required' => trans('messages.bank_id.required'),
            ]
        );
        if ($validator->fails()) {
            $msg = $validator->errors()->getMessages();
            $ms = "Validation error";
            foreach ($msg as $key => $value) {
                $ms = $value[0];
            }
            \Session::flash('error', $ms);

            return redirect()->route('seller.withdrawals');
        }
        $avaliable_amount = $this->actualuser->comission_balance;
        if ((int) $avaliable_amount < (int) $request->amount) {
            \Session::flash('error', trans('messages.donthavebal'));

            return redirect()->route('seller.withdrawals');

        }
        $amount = round($request->amount, 2);
        $requestdb = SellerWithdrawRequest::create([
            'user_id' => $this->user->id,
            'account_number' => $request->account_number,
            'bank_id' => $request->bank_id,
            'name' => $this->user->name,
            'amount' => $amount,
            'status' => "pending"
        ]);
        $this->actualuser->decrement('comission_balance',$amount);
        \Session::flash('success', trans('messages.withdrawrequestsuccess'));

        return redirect()->route('seller.withdrawals');
    }
}
