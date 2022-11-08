<div class="table-responsive">
    <table class="table">
        <thead align="center">
            <tr>
                <th>#Id</th>
                <th>Username</th>
                <th>Ticket Content</th>
                <th>File Attachment</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        @php  $i = 1;  @endphp
        <tbody align="center">

            @if(count($support_tickets) > 0)
            @foreach($support_tickets as $row)
            @if(@$data['status'] && $data['status'] == 'Open')
            @if( ($row->last_message!=null && $row->last_message->reply_from != 'admin') || $row->last_message==null)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$row->user_detail->username}}</td>
                <td  @if($row->last_message!=null) width="25%" @endif >
                    @if($row->messages!=null)
                    @foreach($row->messages as $message)
                    <div class="m-b-sm {{$message!=null && $message->reply_from=='admin'?'text-read':'text-unread'}} {{($message->reply_from == 'admin' ) ? 'admin-message' : 'user-message'}}" >
                        {{$message!=null?$message->message:""}}
                    </div>
                    @endforeach
                    @endif
                </td>
                <td >
                    @if($row->supportattach!=null)

                    @foreach($row->supportattach as $attachment)

                    <a class="font-s-12" href="{{$attachment->file_name}}" target="_blank">
                        <i class="m-menu__link-icon flaticon-attachment"></i>
                        <!-- {{$attachment->file_name}} -->
                    </a>
                    @endforeach
                    @endif
                </td>
                <td>
                    @if($row->status=='1')
                    <label class="label label-primary">Close</label>
                    @elseif($row->last_message!=null && $row->last_message->reply_from == 'admin')
                    <label class="label label-info">Replied</label>
                    @else
                    <label class="label label-warning">Open</label>
                    @endif
                </td>
                <td nowrap>
                    <span class="dropdown">
                        <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
                         {!! Form::hidden('username',$row->user_detail->username) !!}
                         {!! Form::hidden('subject',@$row->subject->subject) !!}
                         {!! Form::hidden('withdraw_request_id',$row->slug) !!}
                         @if($row->status == '0')
                         <a class="dropdown-item" onclick="opFundWallet(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="Reply" href="javascript:;">Reply</a> 
                         <a class="dropdown-item" onclick="closeTicket(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="Close Ticket" href="javascript:;">Close Ticket</a> 
                         @endif
                         <a class="dropdown-item" onclick="showDetail(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="View Detail" href="javascript:;">View Detail</a>
                         
                     </div>
                 </span>
             </td>
             
         </tr>  
         @endif 
         @else
         <tr>
            <td>{{$i++}}</td>
            <td>{{$row->user_detail->username}}</td>
            
            <td  @if($row->last_message!=null) width="25%" @endif >
                @if($row->messages!=null)
                @foreach($row->messages as $message)
                <div class="m-b-sm {{$message!=null && $message->reply_from=='admin'?'text-read':'text-unread'}} {{($message->reply_from == 'admin' ) ? 'admin-message' : 'user-message'}}" >
                    {{$message!=null?$message->message:""}}
                </div>
                @endforeach
                @endif
            </td>
            <td width="5%">
                @if($row->supportattach!=null)

                @foreach($row->supportattach as $attachment)

                <a class="font-s-12" href="{{$attachment->file_name}}" target="_blank">
                    <i class="m-menu__link-icon flaticon-attachment"></i>
                    <!-- {{$attachment->file_name}} -->
                </a>
                @endforeach
                @endif
            </td>
            <td>
                @if($row->status=='1')
                <label class="label label-primary">Close</label>
                @elseif($row->last_message!=null && $row->last_message->reply_from == 'admin')
                <label class="label label-info">Replied</label>
                @else
                <label class="label label-warning">Open</label>
                @endif
            </td>
            <td nowrap>
                <span class="dropdown">
                    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                        <i class="la la-ellipsis-h"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
                     {!! Form::hidden('username',$row->user_detail->username) !!}
                     {!! Form::hidden('subject',@$row->subject->subject) !!}
                     {!! Form::hidden('withdraw_request_id',$row->slug) !!}
                     @if($row->status == '0')
                     <a class="dropdown-item" onclick="opFundWallet(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="Reply" href="javascript:;">Reply</a> 
                     <a class="dropdown-item" onclick="closeTicket(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="Close Ticket" href="javascript:;">Close Ticket</a> 
                     @endif
                     <a class="dropdown-item" onclick="showDetail(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="View Detail" href="javascript:;">View Detail</a>
                     
                 </div>
             </span>
         </td>
     </tr>  
     @endif             
     @endforeach                            
     @else
     <tr>
        <td colspan="10">No any support ticket found.</td>
    </tr>
    @endif
    <tr>
        <td colspan="10" align="right">{!! $support_tickets->render('vendor.default_paginate') !!}</td>
    </tr>

</tbody>
</table>
</div>