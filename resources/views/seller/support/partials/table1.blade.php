<div class="table-responsive">
<table class="table">
    <thead>
        <tr>
            <!-- <th>#Id</th> -->
            <th>Username</th>
            <th>Subject</th>
            <th>Posted</th>
            <th>Status</th>
            <!-- <th>Actions</th> -->
        </tr>
    </thead>
    <!-- @php  $i = 1;  @endphp -->
    <tbody>
        @if(count($support_tickets) > 0)
        @foreach($support_tickets as $row)
        <tr>
            <!-- <td>{{$i++}}</td> -->
            <td>{{$row->user_detail->username}}</td>
            <td>{{$row->subject!=null ? $row->subject->subject : '-'}}</td>            
            <td>{{$row->created_at->format('d/m/Y')}}</td>            
            <td>
                @if($row->status=='1')
                    <label class="label label-primary">Closed</label>
                @elseif($row->last_message!=null && $row->last_message->reply_from == 'admin')
                    <label class="label label-info">Replied</label>
                @else
                    <label class="label label-warning">Open</label>
                @endif
            </td>
            <!-- <td                          
                @if($row->status == '0')
                    {!! Form::hidden('username',$row->user_detail->username) !!}
                    {!! Form::hidden('subject',$row->subject->subject) !!}
                    {!! Form::hidden('withdraw_request_id',$row->slug) !!}
                    <a class="" onclick="opFundWallet(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="Reply" href="javascript:;">Reply</a> | 
                    <a class="" onclick="closeTicket(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="Close Ticket" href="javascript:;">Close Ticket</a> | 
                @endif
                <a class="" onclick="showDetail(this)" data-toggle="tooltip" data-id="{{$row->slug}}"  data-id="{{$row->slug}}" title="View Detail" href="javascript:;">View Detail</a>
            </td> -->
        </tr>               
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