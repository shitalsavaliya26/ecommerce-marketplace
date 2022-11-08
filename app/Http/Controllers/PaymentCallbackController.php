<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Transactionhistoriescustomer;
use App\Transactionhistoriesagent;
use Response;
use Storage;

class PaymentCallbackController extends Controller
{
    public function __construct(){
        // parent::__construct();
        $this->path=storage_path('logs');

    }
    public function ipayCallback(Request $request){

        $merchantcode   = $request->MerchantCode;
        $paymentid      = $request->PaymentId;
        $refno          = $request->RefNo;
        $amount         = $request->Amount;
        $ecurrency      = $request->Currency;
        $remark         = $request->Remark;
        $transid        = $request->TransId;
        $authcode       = $request->AuthCode;
        $status         = $request->Status;
        $errdesc        = $request->ErrDesc;
        $signature      = $request->Signature;

        $order = Order::where('order_id',$refno)->first();
        if($order->is_paid == '1'){
            exit;
        }
        $log_data['data']=$request->all();
        $path = storage_path('logs').'/ipayresponse/';
        $file_name = date('Y-m-d').'_log.log';
        // if(!Storage::exists('logs/'.$path)) {
        //     \File::makeDirectory($path,  $mode = 0755, $recursive = true);
        // }
        $file_path = $path.'/'.$file_name;
        file_put_contents($file_path, "\n===========START ===================\n", FILE_APPEND);
        file_put_contents($file_path, date("d-m-Y H:i") ."===================\n"."  : ".json_encode($log_data)."\n", FILE_APPEND);

        if(!$order){
            file_put_contents($file_path,json_encode(['success' => false, "payload" => array("order_id" => $order->id, "totalamount" => round($amount)), 'message' => trans('messages.orderplaced'), "code" => 500]), FILE_APPEND);
        }

        if($merchantcode != env('merchant_key')){
            file_put_contents($file_path,$merchantcode.' Not matched',FILE_APPEND);
            echo "not matched";
            exit;
        }
        file_put_contents($file_path, "\n============END ==================\n", FILE_APPEND);

        if ($status == 1 || $status == "1") {
            $sign = env('merchant_code').''.env('merchant_key').'6'.$refno.str_replace('.', '', (string)$amount).'MYR1';
            // if($signature != hash('sha256',$sign)){
            //     die('test1');
            // }
            $order->update([
                'status'        => 'pending',
                'is_paid'        => '1',
                'transaction_id' => $transid,
            ]);
            // echo $order->transactionhistoriesagent()->count();
            // echo $order->transactionhistoriescustomer()->count();die();
            if($order->transactionhistoriesagent()->count() > 0){
                $wallet = null;            

                $order->transactionhistoriesagent()
                                                    ->where('order_id',$order->id)
                                                    ->update([
                                                        'user_id' => $order->user_id,
                                                        'order_id' => $order->id,
                                                        'wallet_id' => $wallet,
                                                        'status' => "accept",
                                                        'transaction_id' => $transid,
                                                        'transaction_for' => "payment",
                                                        'amount' => '-' . round($amount),
                                                        'payment_by' => $order->payment_by,
                                                        'comment' => "Payment for Order",
                                                        'payment_ipn_response' => serialize($request->all())
                                                    ]);
            }
            if($order->transactionhistoriescustomer()->count() > 0){

                $order->transactionhistoriescustomer()->updateOrCreate([
                                                        'user_id' => $order->user_id,
                                                        'order_id' => $order->id
                                                    ],[
                                                        'user_id' => $order->user_id,
                                                        'order_id' => $order->id,
                                                        'status' => 'accept',
                                                        'transaction_id' => $transid,
                                                        'transaction_for' => "payment",
                                                        'amount' => '-' . round($amount),
                                                        'payment_by' => $order->payment_by,
                                                        'payment_ipn_response' => serialize($request->all())
                                                ]);
            }
            echo "RECEIVEOK";
            // return "RECEIVEOK"; 
            exit;
            return Response::json(['success' => true, "payload" => array("order_id" => $order->id, "totalamount" => round($amount)), 'message' => trans('messages.paymentsuccess'), "code" => 200], 200);
        } else {
            if($order->transactionhistoriesagent()->count() > 0){

                $order->transactionhistoriesagent()
                                                    ->where('order_id',$order->id)
                                                    ->update([
                                                        'payment_ipn_response' => serialize($request->all())
                                                    ]);
            }
            if($order->transactionhistoriescustomer()->count() > 0){

                $order->transactionhistoriescustomer()->updateOrCreate([
                                                        'user_id'  => $order->user_id,
                                                        'order_id' => $order->id
                                                    ],[
                                                        'payment_ipn_response' => serialize($request->all())
                                                ]);
            }
            $order->update([
                'transaction_id' => $transid,
            ]);
            exit;
        }

        return Response::json(['success' => true, 'message' => trans('messages.paymentfail'), "code" => 500], 500);
        
    }
}
