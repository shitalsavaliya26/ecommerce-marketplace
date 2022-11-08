<?php

namespace App;

use App\Order;
use App\Transactionhistoriesagent;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Model;
use PDF;
use View;

class Order extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'parent_id', 'role_id', 'is_paid', 'payment_by', 'remark', 'transferred_on', 'serial_no', 'courier_company_name', 'status', 'transaction_id', 'receiver_id', 'shipping_charge', 'shipped_date', 'deliverd_date', 'bank_id', 'order_type', 'total_amount', 'discount', 'coupon_id', 'shipping_details', 'shipping_paid_by_agent', 'shipping_fees_paid_by', 'cancel_order_reason','product_discount','product_cashback',
        'used_coins', 'used_coins_in_rm', 'coin_rate'
    ];

    protected $appends = ['is_shipping_show', 'total'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function parent()
    {
        return $this->hasOne('App\User', 'id', 'parent_id');
    }

    public function orderAddress()
    {
        return $this->hasOne('App\OrderAddress', 'order_id', 'id');
    }

    public function user_role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }

    public function coupon()
    {
        return $this->hasOne('App\Coupon', 'id', 'coupon_id');
    }

    public function couponusage()
    {
        return $this->hasOne('App\Couponreport', 'order_id', 'id');
    }
    public function shippingCompany()
    {
        return $this->hasOne('App\ShippingCompany', 'id', 'courier_company_name');
    }

    public function orderImage()
    {
        return $this->hasMany('App\OrderImage', 'order_id', 'id');
    }
    public function tracking_no()
    {
        return $this->hasMany('App\OrderTrackingNumber', 'order_id', 'id');
    }
    public function counriercompanies()
    {
        return $this->hasMany('App\OrderShipping', 'order_id', 'id');
    }

    public function orderProduct()
    {
        return $this->hasMany('App\OrderProduct', 'order_id', 'id');
    }

    public function orderNote()
    {
        return $this->hasMany('App\OrderNote', 'order_id', 'id');
    }

    public function product()
    {
        return $this->hasMany('App\Product', 'id', 'product_id');
    }

    function generate_orderno()
    {
        $order = $this->orderBy('id', 'desc')->limit(1)->first();
        if (count($order) > 0) {
            $orderId = $order->id + 1;
        } else {
            $orderId = 1;
        }
        return "ORD" . date('dm') . rand('4', '9999') . $orderId;
    }

    public function getIsShippingShowAttribute()
    {
        if ($this->shipping_charge > 0) {
            return 1;
        }
        return 0;
    }

    public function getTotalAttribute()
    {
        $total = $this->amount;
        if ($this->shipping_charge > 0 && Auth::user()->role_id < 7 && $this->order_type == '1') {
            $total = $total + $this->shipping_charge;
        }
        if ($this->shipping_charge > 0 && Auth::user()->role_id == 7) {
            $total = $total + $this->shipping_charge;
        }
        if ($this->discount > 0) {
            $total = $total - $this->discount;
        }
        return $total;
    }

    public function orderStatus($order)
    {

        if ($order->status == 'pending') {
            return 'Ordered';
        } elseif ($order->status == 'processing') {
            return 'Packed';
        } elseif ($order->status == 'delivered') {
            return 'Shipped';
        } elseif ($order->status == 'completed') {
            return 'Delivered';
        } elseif ($order->status == 'cancelled') {
            return 'Cancelled';
        } else {
            return 'Pending';
        }
    }

    public function totalAmount($orderProduct)
    {
        $totalAmount = 0;
        foreach ($orderProduct as $product) {
            $subtotal = $product->price * $product->qty;
            $totalAmount = $totalAmount + $subtotal;
        }
        return $totalAmount;
    }
    public function totalAmountForRankUpgrade($orderProduct)
    {
        $totalAmount = 0;
        foreach ($orderProduct as $product) {
            // $product_info = json_decode($product->product_info);
            $subtotal = $product->customer_qty_price * $product->qty;
            $totalAmount = $totalAmount + round($subtotal);
        }
        return $totalAmount;
    }

    public function totalPurchase($orders)
    {
        $orderTotal = 0;
        foreach ($orders as $order) {
            $orderTotal = $orderTotal + $order->totalAmount($order->orderProduct);
        }
        return $orderTotal;
    }

    public function totalQuantity($orderProduct)
    {
        $totalQuantity = 0;
        foreach ($orderProduct as $product) {
            $totalQuantity = $totalQuantity + $product->qty;
        }
        return $totalQuantity;
    }

    public function getorderprice($orderid)
    {
        return $this->hasMany('App\TransactionHistory', 'order_id', 'id')->where('order_id', $orderid)->where('transaction_for', "payment")->where('payment_by', '!=', 0)->first();
    }
    public function getorderpricebyid($orderid)
    {
        $order = $this->find($orderid);
        /*$orderproduct = $this->hasMany('App\OrderProduct', 'order_id', 'id')->where('order_id', $orderid)->get();
        $amount = $order->shipping_charge;
        foreach ($orderproduct as $value) {
        $productprice = $value->price * $value->qty;
        $amount = $amount + $productprice;
        }
        return round($amount);*/
        $amount = $order->total_amount; // + $order->shipping_charge
        return $amount;
    }

    public function getorderpricebyidwithoutshipping($orderid)
    {
        $order = $this->find($orderid);
        /*$orderproduct = $this->hasMany('App\OrderProduct', 'order_id', 'id')->where('order_id', $orderid)->get();
        $amount = 0;
        foreach ($orderproduct as $value) {
        $productprice = $value->price * $value->qty;
        $amount = $amount + $productprice;
        }*/
        return $order->total_amount;
    }

    public function getproductsdetails($orderid)
    {
        return $this->hasMany('App\OrderProduct', 'order_id', 'id')->where('order_id', $orderid)->get();
    }
    public function getproductsdetailsWithseller($orderid)
    {
        return $this->hasMany('App\OrderProduct', 'order_id', 'id')->where('order_id', $orderid)->get()->groupBy('seller_id');
    }
    public function agentreceiver()
    {
        if ($this->role_id == 15) {
            return $this->hasOne('App\Staffreceiver', 'id', 'receiver_id')->select('id', 'name');
        }
        return $this->hasOne('App\Agentreceiver', 'id', 'receiver_id')->select('id', 'name');
    }

    public function staffreceiver()
    {
        return $this->hasOne('App\Staffreceiver', 'id', 'receiver_id')->select('id', 'name');
    }

    public function courier_company()
    {
        return $this->hasOne('App\ShippingCompany', 'id', 'courier_company_name')->select('name');
    }

    public function courier_companydetails()
    {
        return $this->hasOne('App\ShippingCompany', 'id', 'courier_company_name')->select('name', 'link', 'slug');
    }
    public function print_invoice($order_id)
    {
        $filename = "invoice_" . $order_id . ".pdf";
        $file = public_path() . '/invoice/' . $filename;
        if (file_exists($file)) {
            $filepath = url('public') . '/invoice/' . $filename;
            return $filepath;
        } else {
            return null;
        }
    }

    public function getshippingcompanylink()
    {
        return $this->hasOne('App\ShippingCompany', 'id', 'courier_company_name')->select('link');
    }
    public function updateorder($status)
    {

        if ($status == "delivered") {
            if ($this->role_id == 7) {
                $this->delivered_date = now();

                $orderdetails = Order::where('id', $this->id)->with('orderProduct')->first();
                $agenttotal = 0;
                foreach ($orderdetails->orderProduct as $oproductdetails) {
                    $orderproductprice = $oproductdetails->price;
                    $agentproductprice = $this->get_product_price($this->parent_id, $oproductdetails->product_id);
                    $diff = (float) $orderproductprice - (float) $agentproductprice;
                    $diff = $diff * $oproductdetails->qty;
                    $agenttotal = $agenttotal + round($diff);
                    $oproductdetails->agent1productcommission = round($diff);
                    $oproductdetails->save();
                }
                if ($agenttotal > 0) {
                    /*add amount to the agent wallet*/
                    $user = User::find($this->parent_id);
                    $user->comission_balance = $user->comission_balance + $agenttotal;
                    $user->save();

                    /*Add comission to parent agent from customer order*/
                    $history = Transactionhistoriesagent::create([
                        'order_id' => $this->id,
                        'user_id' => $this->parent_id,
                        'status' => 'confirmed',
                        'transaction_for' => 'comission',
                        'transaction_id' => time(),
                        'amount' => $agenttotal,
                        'payment_by' => 0,
                        'wallet_id' => '2',
                        'comment' => "Commission",
                    ]);
                    $this->agent1commission = $agenttotal;
                }
                $Agent2Commission = 0;
                if ($this->parent->parent->role_id != 1) {
                    if ($this->parent->role_id != $this->parent->parent->role_id) {
                        foreach ($orderdetails->orderProduct as $oproductdetails) {
                            $CustomerProductPrice = $oproductdetails->price;
                            $Parent1AgentProductPrice = $this->get_product_price($this->parent_id, $oproductdetails->product_id);
                            $CustomerdiffAgent1 = (float) $CustomerProductPrice - (float) $Parent1AgentProductPrice;
                            $Parent2AgentProductPrice = $this->get_product_price($this->parent->parent_id, $oproductdetails->product_id);
                            $CustomerdiffAgent2 = (float) $CustomerProductPrice - (float) $Parent2AgentProductPrice;
                            $Agent2diff = $CustomerdiffAgent2 - $CustomerdiffAgent1;
                            $t = $Agent2diff * $oproductdetails->qty;
                            $Agent2Commission = $Agent2Commission + round($t);

                            $oproductdetails->agent2productcommission = round($t);
                            $oproductdetails->save();

                        }
                        if ($Agent2Commission > 0) {
                            /*add amount to the parent to parent agent wallet*/
                            $user = User::find($this->parent->parent_id);
                            $user->comission_balance = $user->comission_balance + $Agent2Commission;
                            $user->save();

                            /*Add comission to parent agent from customer order*/
                            $history = Transactionhistoriesagent::create([
                                'order_id' => $this->id,
                                'user_id' => $this->parent->parent_id,
                                'status' => 'confirmed',
                                'transaction_for' => 'comission',
                                'transaction_id' => time(),
                                'amount' => $Agent2Commission,
                                'payment_by' => 0,
                                'wallet_id' => '2',
                                'comment' => "Commission",
                            ]);

                            $this->agent2commission = $Agent2Commission;
                        }
                    }
                }
                try
                {
                    $this->storepdf($this->id);
                } catch (\Exception $e) {
                }
            }
            if ($this->role_id != 7) {
                if ($this->order_type == '1') {
                    $this->delivered_date = now();

                    $orderdetails = Order::where('id', $this->id)->with('orderProduct')->first();
                    $agenttotal = 0;
                    foreach ($orderdetails->orderProduct as $oproductdetails) {
                        $orderproductprice = $oproductdetails->price;
                        $agentproductprice = $this->get_product_price($this->parent_id, $oproductdetails->product_id);
                        $diff = (float) $orderproductprice - (float) $agentproductprice;
                        $diff = $diff * $oproductdetails->qty;
                        $agenttotal = $agenttotal + round($diff);
                        $oproductdetails->agent1productcommission = round($diff);
                        $oproductdetails->save();
                    }
                    $userrole = User::where('id', $this->user_id)->first();
                    $parentrole = User::where('id', $this->parent_id)->first();

                    if ($userrole->role_id > $parentrole->role_id) {
                        if ($agenttotal > 0) {
                            /*Add comission to parent agent from customer order*/
                            $history = Transactionhistoriesagent::create([
                                'order_id' => $this->id,
                                'user_id' => $this->parent_id,
                                'status' => 'confirmed',
                                'transaction_for' => 'comission',
                                'transaction_id' => time(),
                                'amount' => $agenttotal,
                                'payment_by' => 0,
                                'wallet_id' => '2',
                                'comment' => "Commission",
                            ]);

                            /*chnage history status*/
                            $historysave = Transactionhistoriesagent::find($history->id);
                            $historysave->status = "confirmed";
                            $historysave->save();

                            $this->agent1commission = $agenttotal;
                        }

                        /*add amount to the agnt wallet*/
                        $user = User::find($this->parent_id);
                        $user->comission_balance = $user->comission_balance + $agenttotal;
                        $user->save();
                    }
                    try
                    {
                        $this->storepdf($this->id);
                    } catch (Exception $e) {
                    }
                } elseif ($this->order_type == '2') {
                    $this->delivered_date = now();

                    $orderdetails = Order::where('id', $this->id)->with('orderProduct')->first();
                    $agenttotal = 0;
                    foreach ($orderdetails->orderProduct as $oproductdetails) {
                        $orderproductprice = $oproductdetails->price;
                        $agentproductprice = $this->get_product_price($this->user_id, $oproductdetails->product_id);
                        $diff = (float) $orderproductprice - (float) $agentproductprice;
                        $diff = $diff * $oproductdetails->qty;
                        $agenttotal = $agenttotal + round($diff);
                        $oproductdetails->agent1productcommission = round($diff);
                        $oproductdetails->save();
                    }

                    /*add amount to the agent wallet*/
                    $user = User::find($this->user_id);
                    $user->comission_balance = $user->comission_balance + $agenttotal;
                    $user->save();

                    if ($agenttotal > 0) {
                        /*Add comission to parent agent from customer order*/
                        $history = Transactionhistoriesagent::create([
                            'order_id' => $this->id,
                            'user_id' => $this->user_id,
                            'status' => 'confirmed',
                            'transaction_for' => 'comission',
                            'transaction_id' => time(),
                            'amount' => $agenttotal,
                            'payment_by' => 0,
                            'wallet_id' => '2',
                            'comment' => "Commission",
                        ]);

                        $this->agent1commission = $agenttotal;
                    }
                    $Agent2Commission = 0;
                    if ($this->parent->role_id != 1) {
                        if ($this->role_id != $this->parent->role_id) {
                            foreach ($orderdetails->orderProduct as $oproductdetails) {
                                $CustomerProductPrice = $oproductdetails->price;
                                $Parent1AgentProductPrice = $this->get_product_price($this->user_id, $oproductdetails->product_id);
                                $CustomerdiffAgent1 = (float) $CustomerProductPrice - (float) $Parent1AgentProductPrice;
                                $Parent2AgentProductPrice = $this->get_product_price($this->parent_id, $oproductdetails->product_id);
                                $CustomerdiffAgent2 = (float) $CustomerProductPrice - (float) $Parent2AgentProductPrice;
                                $Agent2diff = $CustomerdiffAgent2 - $CustomerdiffAgent1;
                                $diff = $Agent2diff * $oproductdetails->qty;
                                $Agent2Commission = $Agent2Commission + round($diff);
                                $oproductdetails->agent2productcommission = round($diff);
                                $oproductdetails->save();
                            }
                            if ($Agent2Commission > 0) {
                                /*add amount to the parent to parent agent wallet*/
                                $user = User::find($this->parent_id);
                                $user->comission_balance = $user->comission_balance + $Agent2Commission;
                                $user->save();

                                /*Add comission to parent agent from customer order*/
                                $history = Transactionhistoriesagent::create([
                                    'order_id' => $this->id,
                                    'user_id' => $this->parent_id,
                                    'status' => 'confirmed',
                                    'transaction_for' => 'comission',
                                    'transaction_id' => time(),
                                    'amount' => $Agent2Commission,
                                    'payment_by' => 0,
                                    'wallet_id' => '2',
                                    'comment' => "Commission",
                                ]);

                                $this->agent2commission = $Agent2Commission;
                            }
                        }
                    }
                    try
                    {
                        $this->storepdf($this->id);
                    } catch (Exception $e) {
                    }
                }
            }
            $this->status = "delivered";
            $this->save();
        }

        if ($status == "rejected") {
            if ($this->role_id != 7) {
                if ($this->order_type == '1') {
                    $orderdetails = Order::where('id', $this->id)->with('orderProduct')->first();
                    if ($orderdetails->status == "shipped") {
                        /* add total amount refund to agent*/
                        $total = 0;
                        foreach ($orderdetails->orderProduct as $oproductdetails) {
                            $orderproductprice = $oproductdetails->price;
                            $productprice = $orderproductprice * $oproductdetails->qty;
                            $total = $total + $productprice;
                        }
                        if ($this->payment_by == 3) /*payment by wallet*/ {
                            /*Refund history of agent*/
                            $history = Transactionhistoriesagent::create([
                                'order_id' => $this->id,
                                'user_id' => $this->user_id,
                                'status' => 'accept',
                                'transaction_for' => 'refund',
                                'transaction_id' => time(),
                                'amount' => $total,
                                'payment_by' => null,
                                'wallet_id' => '1',
                                'comment' => "Refund",
                            ]);
                            $user = User::where('id', $this->user_id)->first();
                            $user->wallet_amount = $user->wallet_amount + $total;
                            $user->save();
                        }

                        /*deduct shipping from wallet if order is cod */
                        if ($this->payment_by == 1) {
                            $user = User::where('id', $this->user_id)->first();
                            $user->comission_balance = $user->comission_balance - $this->shipping_charge;
                            $user->save();

                            $history = Transactionhistoriesagent::create([
                                'order_id' => $this->id,
                                'user_id' => $this->user_id,
                                'status' => 'confirmed',
                                'transaction_for' => 'shipping_charge',
                                'transaction_id' => time(),
                                'amount' => '-' . $this->shipping_charge,
                                'payment_by' => 0,
                                'wallet_id' => '2', //for commission wallet
                                'comment' => "Deduct shipping charge",
                            ]);
                        }
                    } else {
                        $total = 0;
                        foreach ($orderdetails->orderProduct as $oproductdetails) {
                            $orderproductprice = $oproductdetails->price;
                            $productprice = $orderproductprice * $oproductdetails->qty;
                            $total = $total + $productprice;
                        }
                        if ($this->payment_by == 3) /*payment by wallet*/ {
                            /*Refund history of agent*/
                            $history = Transactionhistoriesagent::create([
                                'order_id' => $this->id,
                                'user_id' => $this->user_id,
                                'status' => 'accept',
                                'transaction_for' => 'refund',
                                'transaction_id' => time(),
                                'amount' => $total,
                                'payment_by' => null,
                                'wallet_id' => '1',
                                'comment' => "Refund",
                            ]);
                            $user = User::where('id', $this->user_id)->first();
                            $user->wallet_amount = $user->wallet_amount + $total;
                            $user->save();
                        }
                    }
                }
            }
            $this->cancel_order_reason = "Cancelled order by admin";
            $this->status = "rejected";
            $this->save();
        }

        /*if ($status == "rejected")
    {
    if ($this->role_id != 7)
    {
    $orderdetails = Order::where('id', $this->id)->with('orderProduct')->first();
    $total = 0;
    foreach ($orderdetails->orderProduct as $oproductdetails)
    {
    $orderproductprice = $oproductdetails->price;
    $productprice = $orderproductprice * $oproductdetails->qty;
    $total = $total + $productprice;
    }
    if ($this->payment_by == 3)
    {

    $history = Transactionhistoriesagent::create([
    'order_id' => $this->id,
    'user_id' => $this->user_id,
    'status' => 'accept',
    'transaction_for' => 'refund',
    'transaction_id' => time(),
    'amount' => $total,
    'payment_by' => null,
    'wallet_id' => '1',
    'comment' => "Refund",
    ]);
    $user = User::where('id', $this->user_id)->first();
    $user->wallet_amount = $user->wallet_amount + $total;
    $user->save();
    }
    if ($orderdetails->status == "shipped")
    {
    if ($this->payment_by == 1)
    {
    $user = User::where('id', $this->user_id)->first();
    $user->comission_balance = $user->comission_balance - $this->shipping_charge;
    $user->save();

    $history = Transactionhistoriesagent::create([
    'order_id' => $this->id,
    'user_id' => $this->user_id,
    'status' => 'confirmed',
    'transaction_for' => 'shipping_charge',
    'transaction_id' => time(),
    'amount' => '-' . $this->shipping_charge,
    'payment_by' => 0,
    'wallet_id' => '2',
    'comment' => "Deduct shipping charge",
    ]);
    }
    }
    }

    }*/

    }
    public function storepdf($order_id)
    {
        // $order = Order::find($order_id);
        // $view = \View::make('order.invoice', ["order" => $order]);
        // $contents = $view->render();
        // return PDF::loadHTML($contents)->save('public/invoice/invoice_' . $order->order_id . '.pdf');
        $order = Order::find($order_id);
        $view = \View::make('order.invoice', ["order" => $order]);
        $contents = $view->render();
        return PDF::loadHTML($contents)->save(public_path('invoice/invoice_' . $order->order_id . '.pdf'));
    }

    public function get_product_price($user_id, $product_id)
    {
        $price = 0;
        $user = User::find($user_id);
        $product = Product::find($product_id);

        if ($user->role_id == 2) {
            $price = $product->diamond_leader_price;
        }
        if ($user->role_id == 3) {
            $price = $product->plat_leader_price;
        }
        if ($user->role_id == 4) {
            $price = $product->gold_leader_price;
        }
        if ($user->role_id == 5) {
            $price = $product->silver_leader_price;
        }
        if ($user->role_id == 6) {
            $price = $product->executive_leader_price;
        }
        if ($user->role_id == 7) {
            $price = $product->customer_price;
        }
        if ($user->role_id == 15) {
            $price = $product->staff_price;
        }

        return $price;
    }
/* customer order profit */
    public function getCOrderAgentProfit($orderid)
    {
        $order = $this->with('orderProduct')->find($orderid);
        $profit = 0;
        //Agent Profit = Order Price(Customer Price) - Agent Price
        foreach ($order->orderProduct as $orderProduct) {
            $order_price = $orderProduct->price * $orderProduct->qty;
            $agent_price = $orderProduct->agent_price * $orderProduct->qty;
            $profit += $order_price - $agent_price;
        }
        return $profit;
    }
    public function getCOrderCompanyProfit($orderid)
    {
        $order = $this->with('orderProduct')->find($orderid);
        $profit = 0;
        //Comapny Profit = Order Price(Customer Price) - Cost - Agent Profit
        foreach ($order->orderProduct as $orderProduct) {
            $cost_price = $orderProduct->cost_price * $orderProduct->qty;
            $order_price = $orderProduct->price * $orderProduct->qty;
            $profit += $order_price - $cost_price;
        }
        $profit -= $this->getCOrderAgentProfit($orderid);
        return $profit;
    }
    // calculate Company profit
    public function getCompanyProfit($orderid)
    {
        $order = $this->with('orderProduct')->find($orderid);
        $profit = 0;
        foreach ($order->orderProduct as $orderProduct) {
            $cost_price = $orderProduct->cost_price * $orderProduct->qty;
            $order_price = ($orderProduct->price * $orderProduct->qty) - $orderProduct->discount;
            $profit += $order_price - $cost_price;
        }
        return $profit;
    }
    // calculate Agent rofit
    public function getAgentProfit($orderid)
    {
        $order = $this->with('orderProduct')->find($orderid);
        $profit = 0;
        foreach ($order->orderProduct as $orderProduct) {
            $agent_price = $orderProduct->price;
            $order_price = ($orderProduct->price * $orderProduct->qty) - $orderProduct->discount;
            $profit += $order_price - $agent_price;
        }
        return $profit;
    }
    // calculate Agent rofit
    public function getStaffProfit($orderid)
    {
        $profit = 0;
        return $profit;
        if ($this->orderProduct) {
            $order = $this->with('orderProduct')->find($orderid);
            if ($order->orderProduct) {
                foreach ($order->orderProduct as $orderProduct) {
                    $product = Product::find($orderProduct->product_id);
                    if ($product->staff_commission_price && $orderProduct->qty) {
                        $profit += $product->staff_commission_price * $orderProduct->qty;
                    }
                }
            }
        }

    }

    public function orderVouchers()
    {
        return $this->hasMany(OrderVoucher::class);
    }

    public function productVoucher()
    {
        return $this->hasOne('App\Voucher', 'id', 'coupon_id');
    }

}
