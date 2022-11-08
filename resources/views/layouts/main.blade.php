<!doctype html>
    <html lang="en">

    <head>
        <title> {{env('APP_NAME')}} | @yield('title','Dashboard')</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('assets/bootstrap/css/slick.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{asset('assets/css/style.css').'?v='.time() }}">
        <link rel="stylesheet" href="{{  asset('assets/css/toastr.min.css') }}">

        <style>
            .error{
                color:red;
            }
        </style>
        @yield('css')
    </head>
    <body> 
        @include('layouts.header')

        @yield('content')

        <div id="loader"></div>
        <div class="modal fade" id="contactseller" tabindex="-1" role="dialog" aria-labelledby="newticketsLabel"aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title inline" id="exampleModalLabel">{{trans('custom.create_new_ticket')}}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{Form::open(['route' => 'help-support.store','class' => '','id' =>'support-ticket','enctype' => 'multipart/form-data'])}}
                    <div class="modal-body">
                        <input type="hidden" name="reference_id" id="reference_id">
                        <div class="form-group row">
                            <div class="col-lg-12 form-group-sub">
                                <div class="form-group">
                                    <div class="from-inner-space">
                                        <label class="mb-2 bmd-label-static">{{trans('custom.title')}}:
                                            <span class="text-red">*</span>
                                        </label>
                                        {!! Form::select('subject_id',$supportSubject,old('supportSubject'),['class'=>'form-control','placeholder'=>'Select Title','required']) !!}            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 form-group-sub">
                                <div class="form-group">
                                    <div class="from-inner-space">
                                        <label class="mb-2 bmd-label-static">{{trans('custom.attachment')}}:</label>
                                        <input name="attachment[]" type="file" multiple  required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 form-group-sub">
                                <div class="form-group">
                                    <div class="from-inner-space">
                                        <label class="mb-2 bmd-label-static">{{trans('custom.message')}}:<span class="text-red">*</span></label>
                                        {!! Form::textarea('message', null, ['class'=> 'form-control' ,'id' => 'message', 'rows' => 4, 'cols' => 54,'required']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group row">
                            <div class="col-lg-12 form-group-sub">
                                <button type="submit" class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary">{{trans('custom.save')}}</button>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
        @include('layouts.footer')
        <script src="{{ asset('assets/bootstrap/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
        <script src="{{asset('assets/bootstrap/js/slick.min.js')}}"></script>
        <script src="{{asset('assets/js/bootbox.min.js')}}"></script>
        <script src="{{ asset('assets/js/TweenMax.min.js') }}"></script>
        <script src="{{asset('assets/js/custom.js').'?v='.time() }}"></script>
        <script src="{{ asset('assets/js/toastr.min.js')}}"></script>
        <script src="{{ asset('assets/js/form-controlller.js').'?v='.time() }}"></script>
        <script>
            @if (Session::has('success'))
            toastr.success("{{Session::get('success')}}");
            @endif
            @if (Session::has('error'))
            toastr.error("{{Session::get('error')}}");
            @endif
        </script>
        <script>
            var spinner = $('#loader');
            $(function() {
                $('form').submit(function(e) {
                    spinner.show();
                    setTimeout(() => spinner.hide(), 1000);
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on("click",".search-data",function() {
                var keyword = $('#searchKeyword').val();
                if(keyword != '' && keyword != null){    
                    $.ajax({
                        url  : '{{route("addKeyword")}}',
                        type : 'POST',
                        data : {'keyword': keyword },
                        success: (response) => {

                        },
                        error: function(jqXHR, textStatus, errorThrown) {

                        }
                    });
                }
            });

            function contactsell(ele){
                var data = $(ele).data('id');
                $('#reference_id').val(data);
                $('#contactseller').modal('show');
            }
            $(".dropdown-item").click(function(){
                var selText = $(this).text();
                $('#dropdownMenuButton').find('span').html(selText+' <span class="caret"></span>');
            });
            var o = "{{$searchKeywords}}";

            var showHints = function(){
                var str = $('#searchKeyword').val().toLowerCase();
                $('.dropdown-menu').html("");
                if ( typeof str != "undefined" && str !== "" ) {
                    @foreach($searchKeywords as $keyword)
                    $('.dropdown-menu').append('<li><a href="{{route("searchfilter")}}?search={{$keyword}}">{{$keyword}}</a></li>')
                    @endforeach
                    // for ( var el of o) {
                    //     var name = el.name.toLowerCase();
                    //     if ( name.indexOf(str) !== -1 ){
                    //         $('.dropdown-menu').append('<li><a href="{{route("searchfilter")}}?search='+el.name+'">'+el.name+'</a></li>')
                    //     }
                    // }
                    $('.dropdown').dropdown();
                } 
            }
        </script>
        @yield('script')
    </body>
    </html>
