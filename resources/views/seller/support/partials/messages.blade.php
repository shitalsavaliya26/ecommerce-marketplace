
<h4><strong>Username:</strong>&nbsp;&nbsp;{{$support_ticket->user_detail->name}}</h4>
<h4><strong>Subject:</strong>&nbsp;&nbsp;{{$support_ticket->subject->subject}}</h4>
<div class="chat-discussion">

    @if(count($support_ticket->messages))
        @foreach($support_ticket->messages as $key => $value)
        <div class="chat-message {{($value->reply_from == 'user') ? 'left' : 'right'}}">
            <div class="message ">
                <a class="message-author m-b-10" href="javascript:;"> {{
                    ($value->reply_from == 'user') ? $support_ticket->user_detail->name : 'You'
                    }}
                </a>
                <span class="message-date m-b-10"> {{$value->created_at->diffForHumans()}} </span>
                <span class="message-content text-left"> {{$value->message}} </span>
            </div>
        </div>
        @endforeach
    @else
        No ticket found
    @endif
</div>