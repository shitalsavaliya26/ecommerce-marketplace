@extends('layouts.main')
@section('title', 'Help & Support')
@section('content')
<section class="bg-gray pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12">
                <div class="row bg-white mx-0 br-15 p-4 shadow overflow-hidden">
                    <div class="iq-card float-e-margins cus-blue-bg iq-banner-wallet iq-report-wallet mb-0 brdr-lr-btm">
                        <div class="row align-items-center ">
                            <div class="col-12 col-lg-12">
                                <h2 class="banner-border mb-2"><span class="fw-500">{{trans('custom.help_support')}} <a href="{{route('help-support.index')}}" class="btn btn-info m-badge--wide delivery-status">< Back</a></span></h2>
                            </div>
                        </div>
                        <div class="row animated fadeInRight">
                            <div class="col-lg-12 col-md-12">
                                <div class="iq-card float-e-margins cus-box-shadow cus-blue-bg brdr-lr-top">
                                    <div class="iq-card-body cus-dblue-bg">
                                        <div class="row wrapper mb-4">
                                            <div class="col-lg-12">
                                                <h2 class="banner-border">{{$supportChat->subject['subject_en']}}</h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-12">
                                                <div class="chat-discussion">
                                                    @if(count($supportChat->messages))
                                                        @foreach($supportChat->messages as $key => $value)
                                                            <div class="col-md-11 col-lg-12 col-xl-12">
                                                                <ul class="list-unstyled">
                                                                    @if($value->reply_from == 'user')
                                                                        <li class="d-flex justify-content-between mb-4">
                                                                            <img onerror="this.src='{{asset('assets/images/User.png')}}'"  src="{{ Auth::user()->image }}" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                                                                            <div class="card">
                                                                                <div class="card-header d-flex justify-content-between p-3">
                                                                                    <p class="fw-bold mb-0">You</p>
                                                                                    <p class="text-muted small mb-0"><i class="far fa-clock"></i> {{$value->created_at->diffForHumans()}}</p>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <p class="mb-0"> {!! nl2br($value['message']) !!} </p>
                                                                                    @if(!empty($value->attchment) && isset($value->attchment[0]))
                                                                                        @foreach($value->attchment as $keyAttach => $valueAttach)
                                                                                            @php
                                                                                                $proofType = 0;
                                                                                                if($valueAttach->file_name !=null && $valueAttach->file_name != ''){
                                                                                                    $proofType = substr(strrchr($valueAttach->file_name,'.'),1);
                                                                                                }
                                                                                            @endphp
                                                                                            <span class="message-content text-left">
                                                                                                @if( $proofType ==  'pdf' || $proofType ==  'doc' || $proofType ==  'docx')
                                                                                                <a href="{{$valueAttach->file_name}}" width="20" target="_blank"><i class="fa fa-file i-con-2"></i></a>
                                                                                                @else
                                                                                                <a href="{{$valueAttach->file_name}}" width="20" target="_blank"><img src="{{$valueAttach->file_name}}" width="20" class="img-responsive"></a>
                                                                                                @endif
                                                                                            </span>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @else
                                                                        <li class="d-flex justify-content-between mb-4">
                                                                            <div class="card w-100">
                                                                                <div class="card-header d-flex justify-content-between p-3">
                                                                                    <p class="fw-bold mb-0">Owner</p>
                                                                                    <p class="text-muted small mb-0"><i class="far fa-clock"></i> {{$value->created_at->diffForHumans()}}</p>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <p class="mb-0">
                                                                                        {!! nl2br($value['message']) !!}
                                                                                    </p>
                                                                                    <br>
                                                                                    @if(!empty($value->attchment) && isset($value->attchment[0]))
                                                                                        @foreach($value->attchment as $keyAttach => $valueAttach)
                                                                                            @php
                                                                                            $proofType = 0;
                                                                                            if($valueAttach->file_name !=null && $valueAttach->file_name != ''){
                                                                                                $proofType = substr(strrchr($valueAttach->file_name,'.'),1);
                                                                                            }
                                                                                            @endphp
                                                                                            <span class="message-content text-left">
                                                                                                @if( $proofType ==  'pdf' || $proofType ==  'doc' || $proofType ==  'docx')
                                                                                                <a href="{{$valueAttach->file_name}}" width="20" target="_blank"><i class="fa fa-file i-con-2"></i></a>
                                                                                                @else
                                                                                                <a href="{{$valueAttach->file_name}}" width="20" target="_blank"><img src="{{$valueAttach->file_name}}" width="20" class="img-responsive"></a>
                                                                                                @endif
                                                                                            </span>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <img src="{{asset('assets/images/User.png')}}" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        No ticket found
                                                    @endif
                                                </div>

                                                @if($supportChat->status == 0)
                                                <div class="support-replay m-t-lg">
                                                    {{Form::open(['route' => 'supportReplayPost','class' => 'px-4 py-4 bg-gray-light','id' =>'support-ticket','enctype' => 'multipart/form-data'])}}
                                                        {{Form::hidden('ticket_id',$ticket_id,['class' => 'form-control','readonly' => true])}}
                                                        <div class="form-group row">
                                                            <div class="col-lg-12 form-group-sub">
                                                                <div class="form-group">
                                                                    <div class="from-inner-space">
                                                                        <label class="mb-2 bmd-label-static">{{trans('custom.attachment')}}:</label>
                                                                        <input name="attachment[]" type="file" multiple  />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-12 form-group-sub">
                                                                <div class="form-group">
                                                                    <div class="from-inner-space">
                                                                        <label class="mb-2 bmd-label-static">{{trans('custom.message')}}:<span class="text-red">*</span></label>
                                                                        {!! Form::textarea('message', null, ['class'=> 'form-control' ,'id' => 'message', 'rows' => 4, 'cols' => 54]) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-lg-12 form-group-sub">
                                                                <button type="submit" class="btn bg-orange orange-btn text-white font-16 rounded px-5 font-GilroySemiBold">{{trans('custom.replay')}}</button>
                                                            </div>
                                                        </div>
                                                    {{Form::close()}}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="wrapper wrapper-content">

</div>
@endsection

@section('scripts')
@endsection
