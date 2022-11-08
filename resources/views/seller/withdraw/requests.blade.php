@extends('seller.layouts.main')
@section('title', 'Withdrawal requests')

@section('content')
<style>
    select,input{
        padding: 0.60rem 1.00rem !important;
    }
    .form-control-feedback{
        color: red;
    }
</style>
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{ url('/')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="{{ route('seller.withdrawals')}}" class="m-nav__link">
                        <span class="m-nav__link-text">Withdraw request</span>
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
                        Withdraw request
                    </h3>
                </div>
            </div>
            <!-- <div class="m-portlet__head-tools">
                <h3 class="m-portlet__head-text">
                    Total Amount : RM {{ number_format($totalAmount,2) }}
                </h3>
            </div> -->
        </div>
        <div class="m-portlet__body">

            @if (\Session::has('success'))
            <div class="col-xl-12 m-section__content toast-container ">
                <div class="m-alert m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                    <strong> {!! \Session::get('success') !!}</strong>
                </div>
            </div>
            @endif
            @if (\Session::has('error'))
            <div class="col-xl-12 m-section__content">
                <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                    <strong> {!! \Session::get('error') !!}</strong>
                </div>
            </div>
            @endif

            <div class="row multidiv " style="display:none;" >
                <div class="col-md-12 align-right loading-show">
                    <button  type="button" class=" btn btn-primary btn-send-request font12 " onclick="multisubmit('accept');">
                        <span>
                            <span>Accept</span>
                        </span>
                    </button>
                    <button  type="button" class=" btn btn-secondary font12  "  onclick="multisubmit('reject');" style="margin-left: 5px;" >
                        <span>
                            <span>Reject</span>
                        </span>
                    </button>
                </div>
            </div>
            <br/>

            <form method="get" id="searchForm" action="">
                <div class="row">                   
                    <div class="col-md-2">
                        <div class="form-group m-form__group">
                            <select class="form-control m-input" name="status">
                                <option value="" >Select Status</option>

                                <option value="pending" @if (@$status == 'pending' ) selected="selected" @endif >Pending</option>

                                <option value="accept" @if (@$status == 'accept' ) selected="selected" @endif >Accepted</option>

                                <option value="reject" @if (@$status == 'reject' ) selected="selected" @endif >Rejected</option>
                            </select>
                        </div>  
                    </div>

                    <div class="col-md-2">
                        <div class="form-group m-form__group">
                            <div class="m-input-icon ">
                                <span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-calendar-check-o"></i></span></span>
                                <input type="text" name="fromDate" autocomplete="off" class="form-control m-input" id="fromDate" value="{{ @$fromDate }}" placeholder="From Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group m-form__group">
                            <div class="m-input-icon " id="m_daterangepicker_2">
                                <input type="text" name="toDate" class="form-control m-input" id="toDate" autocomplete="off" value="{{ @$toDate }}" placeholder="To Date">
                                <span class="m-input-icon__icon m-input-icon__icon--right">
                                    <span>
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 align-right">
                        <button  type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--air">
                            <span>
                                <span>Go</span>
                            </span>
                        </button>
                        <button  type="reset" id="resetButon" class="btn btn-default m-btn m-btn--custom m-btn--air">
                            <i class="la la-refresh"></i>
                        </button>
                        <a href="{{route('seller.withdrawals.create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--air">Add request</a>
                    </div>
                </div>
            </form>

            <table class="table table-striped- table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="m_table_1">
                <thead>
                    <tr>
                        <th>Amount</th> 
                        <th>Request on</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($Withdraw) == 0)
                    <tr>
                        <td colspan="8" class="text-center">No record found</td>
                    </tr>
                    @endif
                    @foreach($Withdraw as $row)
                    <tr>
                        <td>RM {{ number_format($row->amount,2) }}</td>
                        <td>{{ date('d/m/Y h:i:s',strtotime($row->created_at)) }}</td>

                        <td>
                            @if($row->status == 'pending')
                            <span class="m-badge m-badge--brand m-badge--wide">Pending</span>
                            @elseif($row->status == 'accept')
                            <span class="m-badge m-badge--success m-badge--wide">Accepted</span>
                            @elseif($row->status == 'reject')
                            <span class="m-badge m-badge--danger m-badge--wide">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"><h3 class="m-portlet__head-text"><b>Total Amount :</b>
                            
                           RM {{ number_format($totalAmount,2) }}
                       </h3></td>
                   </tr>
               </tbody>
           </table>
           {{ $Withdraw->appends(\Request::all())->render() }}
       </div>
       <script type="text/javascript">

        jQuery(document).ready(function() {    
            $('#fromDate').datepicker({
                autoclose: true,
            });
            $('#toDate').datepicker({
                autoclose: true,
            });
            


            $('.multidiv').hide();

           /* $('input[type="checkbox"]').click(function(){
                if($('input[type="checkbox"]:checked').length == 0){
                    $(".multidiv").slideUp(500);
                }
                else{
                    $(".multidiv").slideDown(500);
                }
            });*/

            $("#checkall").change(function() {
                if(this.checked) {
                    $('input:checkbox').prop('checked',true);
                }else{
                    $('input:checkbox').prop('checked',false);
                }
                checkchecker();
            });

            $('input[type="checkbox"]').click(function(){
                checkchecker();
            });

            $('.submitConfirm').click(function(){
                if($.trim($('#c_description').val()) == ''){
                    bootbox.alert('Please enter reason');
                }else{
                    $('#description').val($('#c_description').val());
                    $('.loading-show').html('<img src="{{ asset("/public/images/loading.png") }}"  alert="loading...." width = "44px" >');
                    $( "#multiform" ).submit();
                }
            });
        });

        function multisubmit(val){
            $('#req_status').val(val);
            if($('.m-checkbox:checked').length == 1){
                var msg = 'Are you sure you want to '+val+' the request?'
            }else{
                var msg = 'Are you sure you want to '+val+' all selected request?';
            }
                // console.log(val);
                bootbox.confirm(msg, function(result){ 
                    if(result == true)
                    {
                        if (val == "accept") 
                        {
                            $('.loading-show').html('<img src="{{ asset("/public/images/loading.png") }}"  alert="loading...." width = "44px" >');
                            $( "#multiform" ).submit();
                        }
                        else
                        {
                            $('#m_modal_4').modal('show');
                        }
                    }
                });
            }

            function checkchecker(){
            /*if ($('.m-checkbox:checked').length == $('.check').length ) 
            {
                $("#checkall").checked(true);
                //$('#checkall').prop('checked',true);
            }
            else
            {
                $("#checkall").checked(true);
            }*/
            if($('.m-checkbox:checked').length == 0){
                $(".multidiv").slideUp(500);
            }
            else{
                $(".multidiv").slideDown(500);
            }
        }
        
    </script>
    @endsection
