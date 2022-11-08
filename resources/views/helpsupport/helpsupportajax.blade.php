<div class="col-12 mt-2  table-responsive" id="cancelled">
    <table class="table history-table">
        <thead>
            <tr>
                <!-- <th class="control-label">Id</th> -->
                <th class="control-label">{{trans('custom.subject')}}</th>
                <th class="control-label">{{trans('custom.posted')}}</th>
                <th class="control-label">{{trans('custom.status')}}</th>
                <th class="control-label"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($supportTicket))
            @foreach($supportTicket as $key => $value)
            <tr>    
            <!-- <td class="table-data" data-name="{{trans('custom.status')}}">
                {{$value->id}}
            </td> -->
            <td class="table-data" data-name="{{trans('custom.subject')}}" >
                {{$value->subject[$locale]}}
            </td>
            <td class="table-data" data-name="{{trans('custom.posted')}}">
                
                {{\Carbon\Carbon::parse($value->created_at)->format('d-m-Y h:i:s')}}
                
            </td>
            
            <td class="table-data" data-name="{{trans('custom.status')}}">
                @if($value->status == 0)
                <small class="label label-danger span-label bg-green">{{trans('custom.open')}}</small>
                @else
                <small class="label label-success span-label bg-red">{{trans('custom.close')}}</small>
                @endif

            </td>
            <td class="table-data" data-name="{{trans('custom.action')}}">
                <a href="{{route('supportReplay',$value->slug)}}" class="cus-text-red" title="{{trans('custom.view')}}">View</a>
                {{-- @if($value->status == 0)
                <a href="{{route('supportClose',$value->slug)}}" class="close-ticket drak-color m-l-sm" title="{{trans('custom.close')}}">Close</a>
                @endif --}}
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="no-records text-center">{{trans('custom.no_data_found')}}</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="second-ajax-pag cus-pag-de">
    @if(isset($supportTicket))
    <div class="pagexist">
        {{$supportTicket->render() }}
    </div>
    @endif   
</div>
</div>