<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserBank;
use App\Country;
use App\Rank;
use App\UserWallet;
use App\SupportTicket;
use App\SupportTicketMessage;
use Illuminate\Support\Facades\Crypt;
use App\SupportSubject;
use App\SupportTicketAttachment;
use Session;
use Mail,Storage;
use App\Helpers\Helper;
use App\Seller;

class SupportTicketController extends Controller
{
    public function __construct()
    {
        $this->limit = 10;  
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $locale = 'subject';
        $user = User::where('id',$this->user->id)->where('status','active')->where('is_deleted','0')->first();
        // echo $request->get('htype');
        // exit;
        $query = SupportTicket::where('user_id',$this->user->id);
        if ($request->get('htype') != "" && $request->get('htype') != 2) {
            $query->where('status', $request->get('htype'));
        }
        $general_search = $request->get('general_search');
        if ($general_search && $general_search != '') {
            $query = $query->where(function ($query) use ($general_search) {
                $query->where('message', 'LIKE', '%' . $general_search . '%');
                $query->orWhere('subject_id', 'LIKE', '%' . $general_search . '%');
            });
        }
        $supportTicket = $query->orderBy('created_at', 'desc')->paginate($this->limit);
        if ($request->ajax()) {
            return view('helpsupport/helpsupportajax', compact('supportTicket','locale'));
        }
        // $supportTicket = SupportTicket::where('user_id',$this->user->id)->paginate($this->limit);
        $openTicketCount =  SupportTicket::where('user_id',$this->user->id)->where('status','0')->count();
        $closeTicketCount = SupportTicket::where('user_id',$this->user->id)->where('status','1')->count();
       
        $supportSubject = SupportSubject::where('status','Active')->pluck($locale,'id');
        return view('helpsupport/helpsupport',compact('user','supportTicket','supportSubject','openTicketCount','closeTicketCount','locale'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $usercheck = User::where('id',$this->user->id)->where('status','active')->where('is_deleted','0')->first();
        if($usercheck == null ){
            Session::flash('success',trans('custom.session_has_been_expired_try_agian'));  
            return redirect()->route('help-support.index');
        }
        $reference_id = 1;
        if($request->has('reference_id')){
            $reference_id = Helper::decrypt($request->reference_id);
            $reference_id = ($reference_id != 1) ? Seller::find($reference_id)->user_id : $reference_id;
        }
        // dd(Helper::decrypt($request->reference_id));
        $supportTickes = new SupportTicket;
        $supportTickes->user_id = $this->user->id;        
        $supportTickes->slug = '0'; //open close
        $supportTickes->status = '0'; //open close
        $supportTickes->is_read = '0'; //read and unread
        $supportTickes->reference_id  = $reference_id;
        $supportTickes->type  = ($reference_id != 1) ? 'seller' : 'admin';
        $supportTickes->support_subject_id = $request->subject_id;
        $supportTickes->save();

        $supportTickesMessage = new SupportTicketMessage();
        $supportTickesMessage->support_ticket_id  = $supportTickes->id;

        $supportTickesMessage->message  = $request->message;
        $supportTickesMessage->is_read  = '0';
        $supportTickesMessage->save();

        if($request->hasFile('attachment')){
            foreach($request->file('attachment') as $key => $image) {
                // $filename=time() .'.'. $image->getClientOriginalName();
                // $path = public_path('customer/suport_ticket_attach/');
                // $image->move($path, $filename);
                $filename= time() .$key.'.'. $image->getClientOriginalExtension();    
                 $path = "images/support_ticket_attach/" . $filename;
                $upload_status = Storage::disk('s3')->put($path, file_get_contents($image), 'public');
                $imageurl = Storage::disk('s3')->url($path);   
                // $image->storeAs('suport_ticket_attach',$filename);
                $supportAttach = new SupportTicketAttachment;
                $supportAttach->support_ticket_id = $supportTickes->id;
                $supportAttach->message_id = $supportTickesMessage->id;
                $supportAttach->file_name = $imageurl;
                $supportAttach->save();
            }
        }
        // \Log::channel('supportticket')->info('user created request', ['userwalletobject' => json_encode($supportTickes), 'file' => __FILE__, 'line' => __LINE__]);
        Session::flash('success',trans('custom.ticket_submit'));  
        return redirect()->route('help-support.index');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    /***
     * 
     * suppor replay
     */
    
    public function supportReplay(Request $request){
        $openTicketCount =  SupportTicket::where('user_id',$this->user->id)->where('status','0')->count();
        $closeTicketCount = SupportTicket::where('user_id',$this->user->id)->where('status','1')->count();
        $supportSubject = SupportSubject::where('status','Active')->pluck('subject','id');
        $ticket_id = $request->id;
        $user = User::where('id',$this->user->id)->where('status','active')->where('is_deleted','0')->first();
        
        $supportChat = SupportTicket::with('messages','messages.attchment')->where('slug',$ticket_id)->first();
        if(empty($supportChat)){
            return redirect()->back()->with('error',trans('custom.ticket_not_found') );
        }
        $supportChat->is_read = '1';
        $supportChat->save();
        foreach ($supportChat->messages as $key => $value) {
            $value->is_read = '1';
            $value->save();
        }
        return view('helpsupport/helpsupportreplay',compact('user','openTicketCount','closeTicketCount','supportSubject','ticket_id','supportChat'));
    }

    /***
     * 
     * support replay post
     */
    
    public function supportReplayPost(Request $request){
        $user = User::where('id',$this->user->id)->where('status','active')->where('is_deleted','0')->first();
        if(empty($user)){
            return redirect()->back()->with('error',trans('custom.session_has_been_expired_try_agian') );
        }
        $supportChat = SupportTicket::with('messages')->where('slug',$request->ticket_id)->first();
        if(empty($supportChat)){
            return redirect()->back()->with('error',trans('custom.ticket_not_found') );
        }
        $supportChat->status = '0';
        $supportChat->save();
        $supportTickesMessage = new SupportTicketMessage();
        $supportTickesMessage->support_ticket_id  = $supportChat->id;
        $supportTickesMessage->message  = $request->message;
        $supportTickesMessage->is_read  = '0';
        $supportTickesMessage->save();

        if($request->hasFile('attachment')){
            foreach($request->file('attachment') as $key => $image) {
                // $filename=time() .'.'. $image->getClientOriginalName();
                // $path = public_path('customer/suport_ticket_attach/');
                // $image->move($path, $filename);
                
                $filename= time() .$key.'.'. $image->getClientOriginalExtension();
                 $path = "images/support_ticket_attach/" . $filename;
                $upload_status = Storage::disk('s3')->put($path, file_get_contents($image), 'public');
                $imageurl = Storage::disk('s3')->url($path);

                // $image->storeAs('suport_ticket_attach',$filename);        
                $supportAttach = new SupportTicketAttachment;
                $supportAttach->support_ticket_id = $supportChat->id;
                $supportAttach->message_id = $supportTickesMessage->id;
                $supportAttach->file_name = $imageurl;
                $supportAttach->save();
            }
        }
        return redirect()->back()->with('success', 'Ticket message sent to admin.');
    }
    /***
     * 
     * support ticket close
     */
    
    public function supportClose(Request $request){
        
        $supportTicket = SupportTicket::with('messages')->where('slug',$request->slug)->first();
        if(empty($supportTicket)){
            return redirect()->back()->with('error',trans('custom.ticket_not_found') );
        }
        $supportTicket->status = '1';
        $supportTicket->save();
        return redirect()->back()->with('success', 'Ticket has been closed.');
    }
}
