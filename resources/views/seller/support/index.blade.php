@extends('seller.layouts.main')
@section('content')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{ url('/seller')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Support Tickets</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- END: Subheader -->
<div class="m-content">
    <div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Support Tickets
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body m_datatable m-datatable m-datatable--default m-datatable--loaded  ">
            @if (\Session::has('success'))
            <div class="m-section__content">
                <div class="m-alert m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                    <strong> {!! \Session::get('success') !!}</strong>
                </div>
            </div>
            @endif
            @if (\Session::has('error'))
            <div class="m-section__content">
                <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                    <strong> {!! \Session::get('error') !!}</strong>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-5">
                </div>

                <div class="col-md-2">
                    <form method="get" id="searchForm" action="">
                        <div class="m-input-icon m-input-icon--left">
                         {!! Form::text('search',old('search',@$data['search']),['class'=>'form-control m-input','placeholder'=>'Search by username']) !!}

                         <span class="m-input-icon__icon m-input-icon__icon--left">
                            <span><i class="la la-search"></i></span>
                        </span>
                    </div>
                </div>

                <div class="col-lg-2 form-group m-form__group ">
                    {!! Form::select('status',['Open'=>'Open','Close'=>'Close','Replied'=>'Replied'],old('status',@$data['status']),['class'=>'form-control m-input','placeholder'=>'All']) !!}
                </div>


                <div class="col-md-2 align-right">
                    <button  type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--air">
                        <span>
                            <span class="font12">Go</span>
                        </span>
                    </button>
                    <button  type="reset" id="resetButon" class="btn btn-default m-btn m-btn--custom m-btn--air">
                        <i class="la la-refresh"></i>
                    </button>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </form>
            </div>

        </div>
        <div class="table-responsive">
           @include('seller.support.partials.table')
       </div>
   </div>
   <div id="view_ticket" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="username"></span>[<span class="id"></span>]</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">                
                <div></div>
            </div>
        </div>
    </div>
</div>
   <div id="reply_support" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            {!! Form::open(['route'=>['seller.support_ticket.update',''],'method'=>'post','class'=>'form-vertical','id'=>'reply_support_ticket','autocomplete'=>'false','files'=>true]) !!}
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="modal-header">
                <h4 class="modal-title">Reply <span class="username"></span> to [<span class="id"></span>]</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="ticket_id" value="" />
                    <label>Subject:</label>
                    {!! Form::text('subject',old('amount'),['readonly'=>'true','class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>Select Template: </label>
                    {!! Form::select('template',$templates_list,old('template'),['min'=>'0','class'=>'form-control','placeholder'=>'Select Template']) !!}
                    <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                </div>
                <div class="form-group">
                    <label>Attachment: </label>
                    {!! Form::file('template[]',['multiple'=>'true','class'=>'form-control','accept'=>'application/pdf,image/jpeg,image/png']) !!}
                    <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                </div>
                <div class="form-group">
                    <label>Desctipion:</label>
                    {!! Form::textarea('message',old('message'),['class'=>'form-control','placeholder'=>'Enter Note','rows'=>5,'style'=>'resize:none']) !!}
                    <span class="help-block text-danger">{{ $errors->first('message') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-send-request font12" >Reply</button>
                <a  class="btn btn-secondary font12" data-dismiss="modal">Cancel</a>
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
<script type="text/javascript"> var array_data = @php echo json_encode((array)$templates_data); @endphp</script>
<script type="text/javascript" src="{{asset('js/support_requests.js').'?v='.time()}}"></script>

@endsection
