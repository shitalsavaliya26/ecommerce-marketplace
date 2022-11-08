@extends('seller.layouts.main')
@section('title', 'Dashboard')
@section('css')
<link href="{{asset('backend/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>    
            <div class="col-xs-12 col-md-3 p-0">Support Tickets</div>
            <div class="col-xs-12 col-md-9 text-right">
                
                {!! Form::open(['route' => ['seller.support_ticket.index1',$slug],'class'=>'form-inline','method'=>'get','id'=>'filter_request']) !!}
                <div class="form-group">                                
                    {!! Form::text('search',old('search',@$data['search']),['class'=>'form-control','placeholder'=>'Search by username']) !!}
                </div>            
                <div class="form-group">                                
                    {!! Form::select('subject',$subjects,old('subject',@$data['subject']),['class'=>'form-control','placeholder'=>'All']) !!}
                </div>            
                <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Search</button>
                <a class="btn btn-danger" href="{{route('seller.support_ticket.index')}}">Clear</a>
                {!! Form::close() !!}  
            </div>
        </h2>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-content bg-dark-blue cus-help-nav">        
                    <ul class="nav nav-tabs">
                        <li class="@if($slug=='all') active @endif"><a class="nav-link  help-ajax"  href="{{route('seller.support_ticket.index1','all')}}"> {{trans('custom.all_tickets')}}</a></li>
                        <li class="@if($slug=='open') active @endif""><a class="nav-link help-ajax" href="{{route('seller.support_ticket.index1','open')}}"> {{trans('custom.open')}}</a></li>
                        <li class="@if($slug=='close') active @endif""><a class="nav-link help-ajax" href="{{route('seller.support_ticket.index1','close')}}">{{trans('custom.closed')}}</a></li>
                    </ul>
                    @role('admin')
                    <p class="m-t-md">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#reply_support">{{trans('custom.create_new_ticket')}}</button>
                        <a href="{{route('seller.support_ticket.index')}}" class="btn btn-warning btn-block">View All Tickets</a>
                    </p>
                    @endrole
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="ibox ">
                <div class="ibox-content bg-dark-blue">        
                    <div class="include-html">
                        @include('seller.support.partials.table1')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="reply_support" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            {!! Form::open(['route'=>['seller.support_ticket.store'],'method'=>'post','class'=>'form-vertical','id'=>'support_ticket','autocomplete'=>'false','files'=>true]) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create new ticket</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="ticket_id" value="" />
                    <label>Username:</label> 
                    {!! Form::text('username',old('amount'),['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    <input type="hidden" name="ticket_id" value="" />
                    <label>Subject:</label> 
                    {!! Form::select('subject',$subjects,old('template'),['class'=>'form-control','placeholder'=>'Select Subject']) !!}
                </div>
                <div class="form-group">
                    <label>Attachment: </label> 
                    {!! Form::file('attachment[]',['multiple'=>'true','class'=>'form-control','accept'=>'application/pdf,image/jpeg,image/png']) !!}
                    <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                </div>
                <div class="form-group">
                    <label>Desctipion:</label> 
                    {!! Form::textarea('message',old('message'),['class'=>'form-control','placeholder'=>'Enter Note','rows'=>5,'style'=>'resize:none']) !!}
                    <span class="help-block text-danger">{{ $errors->first('message') }}</span>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" >Create support ticket</button>
                <a  class="btn btn-danger" data-dismiss="modal">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript"> var action_url = "{{route('seller.support_ticket.update','')}}"</script>
<script type="text/javascript"> 
    var detail_url = "{{route('seller.support_ticket.show','')}}"
    var close_ticket_url = "{{route('seller.support_ticket.store')}}"
</script>

<script src="{{asset('backend/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/custom/support_requests.js')}}"></script>
@endsection