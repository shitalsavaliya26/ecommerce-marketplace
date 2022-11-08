<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\Helper;
use App\SupportTicketAttachment;
use App\SupportTicket;
use App\Support;
use App\SupportTicketMessage;
use App\SupportTemplate;
use App\SupportSubject;
use Auth,Storage;

class SupportController  extends Controller
{
    public function __construct(Request $request){
        $this->path = storage_path('logs/user_logs/'.date("Y-m-d").'.log');
        $this->limit = $request->limit?$request->limit:10;
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
        $support_tickets = SupportTicket::with('supportattach', 'subject', 'last_message')
        ->with('user_detail')->whereHas('user_detail', function ($q) {
            $q->whereNotNull('username');
        })->where('type','seller')->where('reference_id',$this->user->id);

        if ($request->status && $request->status != "") {
            $status = ['Open' => '0', 'Close' => '1','Replied' => '0'];
            $support_tickets = $support_tickets->where('status', $status[$request->status]);
            if ($request->status == 'Open') {
                $support_tickets = $support_tickets->where(function ($q) {
                    $q->whereHas('last_message', function ($query) {
                        $query->where('reply_from', '!=', 'admin');
                    })->orWhereDoesntHave('last_message');
                });
            }
            if ($request->status == 'Replied') {
                $support_tickets = $support_tickets->where(function ($q) {
                    $q->whereHas('last_message', function ($query) {
                        $query->where('reply_from', '!=', 'user');
                    });
                });
            }
        }

        if ($request->search && $request->search != "") {
            $support_tickets = $support_tickets->whereHas('user_detail', function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%');
            });
        }

        $data = $request->all();

        $templates = SupportTemplate::all();
        $templates_list = [];
        $templates_data = [];
        foreach ($templates as $key => $value) {
            $templates_list[$value->id] = $value->title;
            $templates_data[$value->id] = $value->message;
        }

        $support_tickets = $support_tickets->orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate($this->limit)->appends($data);
        return view('seller.support.index', compact('support_tickets', 'templates_list', 'templates_data', 'data'));
    }

    /* all support tickets */
    public function index1($slug,Request $request)
    {
        if($slug=='open'){
            $status = '0';
        }else if($slug=='close'){
            $status = '1';
        }
        $support_tickets = SupportTicket::with('supportattach','subject','last_message')->with(['user_detail'=>function($q){
            $q->with('package_detail','downlineuser');
        }])->whereHas('user_detail',function($q){
            $q->whereNotNull('username');
        });
        if($request->subject && $request->subject != ""){
            $status = ['Open'=>'0','Close'=>'1']; 
            $support_tickets = $support_tickets->where('subject_id',$request->subject);
        }
        if($slug!='all'){
            $support_tickets = $support_tickets->where('status',$status);
        }
        if($request->search && $request->search != ""){

            $support_tickets = $support_tickets->whereHas('user_detail',function($q) use ($request){
                $q->where('username','like','%'.$request->search.'%');
            });
        }
        $data = $request->all();

        $subjects  = SupportSubject::pluck('subject','id');

        $support_tickets = $support_tickets->orderBy('status','asc')->orderBy('created_at','desc')->paginate($this->limit1)->appends($data);
        return view('seller.support.index1',compact('support_tickets','subjects','data','slug'));
    }

    public function supportTicketList($slug, Request $request)
    {
        if ($slug == 'open') {
            $status = '0';
        } else if ($slug == 'close') {
            $status = '1';
        }

        $support_tickets = SupportTicket::with('supportattach', 'subject', 'last_message')
        ->with('user_detail')->whereHas('user_detail', function ($q) {
            $q->whereNotNull('username');
        });

        if ($request->subject && $request->subject != "") {
            $status = ['Open' => '0', 'Close' => '1'];
            $support_tickets = $support_tickets->where('support_subject_id', $request->subject);
        }

        if ($slug != 'all') {
            $support_tickets = $support_tickets->where('status', $status);
        }

        if ($request->search && $request->search != "") {
            $support_tickets = $support_tickets->whereHas('user_detail', function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%');
            });
        }

        $data = $request->all();
        $subjects = SupportSubject::pluck('subject', 'id');

        $support_tickets = $support_tickets->orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate($this->limit1)->appends($data);
        return view('seller.support.list', compact('support_tickets', 'subjects', 'data', 'slug'));
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
        if ($request->ajax()) {
            $support_ticket = SupportTicket::with('supportattach', 'subject', 'messages')->with('user_detail')->whereSlug($request->slug)->first();
            $support_ticket->status = '1';
            $support_ticket->save();

            $templates = SupportTemplate::all();
            $templates_list = [];
            $templates_data = [];

            foreach ($templates as $key => $value) {
                $templates_list[$value->id] = $value->title;
                $templates_data[$value->id] = $value->message;
            }

            $support_tickets = SupportTicket::orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate($this->limit);
            $view = view('seller.support.index', compact('support_tickets', 'templates_list', 'templates_data'))->render();
            return response()->json(['status' => 'success', 'data' => $view, 'message' => 'Ticket close successfully.']);
        }

        $usercheck = User::where('username', $request->username)->where('status', 'active')->first();
        if ($usercheck == null) {
            return redirect()->back()->with('error', 'User name not valid.');
        }

        $supportTickes = new SupportTicket;
        $supportTickes->user_id = $usercheck->id;
        $supportTickes->slug = '0'; //open close
        $supportTickes->status = '0'; //open close
        $supportTickes->is_read = '0'; //read and unread
        $supportTickes->support_subject_id = $request->subject;
        $supportTickes->save();

        $supportTickesMessage = new SupportTicketMessage();
        $supportTickesMessage->support_ticket_id = $supportTickes->id;
        $supportTickesMessage->message = $request->message;
        $supportTickesMessage->reply_from = 'admin';
        $supportTickesMessage->is_read = '0';
        $supportTickesMessage->save();

        if ($request->hasFile('attachment')) {
            // if (!\File::isDirectory(public_path('uploads/support_ticket_attach'))) {
            //     \File::makeDirectory(public_path('uploads/support_ticket_attach'), $mode = 0755, $recursive = true);
            // }

            foreach ($request->file('attachment') as $image) {
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = "images/support_ticket_attach/" . $filename;
                $upload_status = Storage::disk('s3')->put($path, file_get_contents($image), 'public');
                $imageurl = Storage::disk('s3')->url($path);
                // $image = $image->move(public_path('uploads/support_ticket_attach'), $filename);
                $supportAttach = new SupportTicketAttachment;
                $supportAttach->support_ticket_id = $supportTickes->id;
                $supportAttach->message_id = $supportTickesMessage->id;
                $supportAttach->file_name = $imageurl;
                $supportAttach->save();
            }
        }
        return redirect()->back()->with('success', 'Ticket create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $support_ticket = SupportTicket::with('supportattach', 'subject', 'messages')->with('user_detail')->whereSlug($id)->first();
        $view = view('seller.support.partials.messages', compact('support_ticket'))->render();
        return response()->json(['status' => 'success', 'data' => $view]);
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
        $support_ticket = SupportTicket::whereSlug($id)->first();

        if ($support_ticket) {
            $support_ticket->is_read = '1';
            $support_ticket->status = '0';
            $support_ticket->save();
            SupportTicketMessage::where(['support_ticket_id' => $support_ticket->id, 'reply_from' => 'user'])->update(['is_read' => '1']);
            $ticket_message = new SupportTicketMessage();
            $ticket_message->support_ticket_id = $support_ticket->id;
            $ticket_message->message = $request->message;
            $ticket_message->reply_from = 'admin';
            $ticket_message->save();

            if ($request->hasFile('template')) {
                foreach ($request->file('template') as $image) {
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $path = "images/support_ticket_attach/" . $filename;
                    $upload_status = Storage::disk('s3')->put($path, file_get_contents($image), 'public');
                    $imageurl = Storage::disk('s3')->url($path);  
                    // $image->storeAs('support_ticket_attach', $filename);
                    $supportAttach = new SupportTicketAttachment;
                    $supportAttach->support_ticket_id = $support_ticket->id;
                    $supportAttach->message_id = $ticket_message->id;
                    $supportAttach->file_name = $imageurl;
                    $supportAttach->save();
                }
            }

            if ($request->ajax()) {
                $support_tickets = SupportTicket::with('supportattach', 'subject', 'last_message')->with('user_detail')->whereHas('user_detail', function ($q) {
                    $q->whereNotNull('username');
                });
                $support_tickets = $support_tickets->orderBy('status', 'asc')->orderBy('created_at', 'desc');
                $support_tickets = $support_tickets->paginate($this->limit);
                $support_tickets = $support_tickets->setPath(route('seller.support_ticket.index'));
                $html = view('seller.support.partials.table', compact('support_tickets'))->render();

                return response()->json(['status' => 'success', 'data' => $html, 'message' => 'Reply sent successfully.']);
            }
            return redirect()->back()->with('success', 'Reply sent successfully.');
        } else {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
            }
            return redirect()->back()->with('with', 'Something went wrong.');
        }
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
