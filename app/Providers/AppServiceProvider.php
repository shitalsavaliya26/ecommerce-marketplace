<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\UserAddress;
use App\Agentreceiver;
use App\Staffreceiver;
use App\Seller;
use App\Cart;
use App\PushNotification;
use Auth;
use App\FooterLink;
use App\SupportSubject;
use App\SearchKeyword;
use Cookie;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('*', function ($view) {
            $cart = 0;
            $user = [];
            $addresses = [];
            $defaultaddress = [];
            $current_address = [];
            $cartitems = [];
            $notification = [];
            $notifications = $limitNotifications = [];
            $supportSubject = [];
            $notificationCount = 0;
            $language = 'Language';
            $customerService = FooterLink::with('cmsPage')->whereHas('cmsPage')->where('type', 'customer service')->orderBy('id', 'ASC')->get();
            $aboutMaxshop = FooterLink::with('cmsPage')->whereHas('cmsPage')->where('type', 'about maxshop')->orderBy('id', 'ASC')->get();
            $sellers = Seller::where('id', 1)->get();
            $lastsearch = session()->get('cartItems');
            // dd($lastsearch);
            $searchKeywords = $keywords = SearchKeyword::where('category', NULL)->orderBy('times', 'DESC')->limit(8)->pluck('keyword');
            if($lastsearch){
                $searchKeywords = array_unique(array_merge($lastsearch,$keywords)) ;
            }
            if (Auth::check() && Auth::user()->role_id != 16) {
                $user = Auth::user();
                if($user->role_id == '7'){
                    $addresses = $user->address;
                    $defaultaddress = ($user->defaultaddress) ? $user->defaultaddress : $user->address()->first();
                    if(!$defaultaddress){
                         $address = UserAddress::create([
                            'user_id' => $user->id,
                            'name' => $user->name,
                            'contact_number' => $user->contact_number,
                            'country_code' => '+60',
                            'address_line1' => $user->state,
                            'address_line2' => $user->state,
                            'state' => $user->state,
                            'town' => '',
                            'postal_code' => '',
                            'country' => '',
                            'is_default' => 1,
                        ]);
                    }
                    $current_address = ($user->current_address->count() > 0) ? $user->current_address->first() : $defaultaddress;
                }elseif($user->role_id == '15'){
                    $addresses = $user->staffReceivers;
                    $defaultaddress = $user->staffReceivers()->first();
                    if(!$defaultaddress){
                        $address = Staffreceiver::create([
                            'staff_id' => $user->id,
                            'name' => $user->name,
                            'contact_no' => $user->contact_number,
                            'countrycode' => '+60',
                            'address_line1' => $user->state,
                            'address_line2' => $user->state,
                            'state' => $user->state,
                            'town' => '',
                            'postal_code' => '',
                            'country' => '',
                            'address_for' => 1,
                            'is_default' => 1,
                        ]);
                    }
                    $current_address = ($user->currentStaffAddress && $user->currentStaffAddress->count() > 0) ? $user->currentStaffAddress : $defaultaddress;
                }else{
                    $addresses = $user->agentReceivers;
                    $defaultaddress = $user->agentReceivers()->first();
                    if(!$defaultaddress){
                        $address = Agentreceiver::create([
                            'agent_id' => $user->id,
                            'name' => $user->name,
                            'contact_no' => $user->contact_number,
                            'countrycode' => '+60',
                            'address_line1' => $user->state,
                            'address_line2' => $user->state,
                            'state' => $user->state,
                            'town' => '',
                            'postal_code' => '',
                            'country' => '',
                            'address_for' => 1,
                            'is_default' => 1,
                        ]);
                    }
                    $current_address = ($user->currentAgentAddress && $user->currentAgentAddress->count() > 0) ? $user->currentAgentAddress : $defaultaddress;
                }
                $cart = Cart::wherehas('productdetails', function ($query) {
                                    $query->where('is_deleted', '0')
                                    ->where('status', "active");
                                })->with('variation')
                                ->where('user_id', $user->id)
                                ->count();
                $cartitems = Cart::wherehas('productdetails', function ($query) {
                                    $query->where('is_deleted', '0')
                                    ->where('status', "active");
                                })->with('variation')
                                ->where('user_id', $user->id)
                                ->limit(6)
                                ->get();

                $limitNotifications = PushNotification::where('receiver_id', $user->id)->orderBy('id', 'DESC')->limit(5)->get();
                $notificationCount = PushNotification::where('receiver_id', $user->id)->count();
                $supportSubject = SupportSubject::where('status','Active')->pluck('subject','id');

            }elseif (Auth::check() && Auth::user()->role_id == 16) {
                $user = Auth::user();
                $supportSubject = SupportSubject::where('status','Active')->pluck('subject','id');

            }else{
                $cartItems = session()->get('cartItems');
                $cart = (!empty($cartItems))? count($cartItems) : 0;
            }
            $lang = app()->getLocale();
            switch ($lang) {
                case 'en':
                    $language = 'English';
                    break;

                case 'ch':
                    $language = 'Chinese';
                    break;

                case 'my':
                    $language = 'Malay';
                    break;

                case 'th':
                    $language = 'Thai';
                    break;

                case 'vi':
                    $language = 'Vietnamese';
                    break;
                
                default:
                    // code...
                    break;
            }
            view()->share(['cart' => $cart, 'user' => $user, 'addresses' => $addresses, 'defaultaddress' => $defaultaddress,
             'current_address' => $current_address, 'cartitems' => $cartitems, 'sellers' => $sellers, 'notificationCount' => $notificationCount,
             'customerService' => $customerService, 'aboutMaxshop' => $aboutMaxshop, 'limitNotifications' => $limitNotifications, 'supportSubject' => $supportSubject,'language' => $language,
             'searchKeywords' => $searchKeywords]);
        });
    }
}
