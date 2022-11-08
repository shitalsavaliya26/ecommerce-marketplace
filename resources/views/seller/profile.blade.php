@extends('seller.layouts.main')

@section('content')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="{{ url('seller')}}" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
				<li class="m-nav__separator">-</li>
				<li class="m-nav__item">
					<a href="{{ route('seller.profile')}}" class="m-nav__link">
						<span class="m-nav__link-text">Profile</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- END: Subheader -->
<div class="m-content">
    <div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Profile                         
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row" id="app_massges">
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
            </div>
            <form method="post" action="{{route('seller.profile.update',App\Helpers\Helper::encrypt($seller->id))}}" id="seller_edit_form" enctype="multipart/form-data">
				{{ csrf_field() }}
            {{ method_field('PUT') }}

				<div class="m-portlet__body">
                    <div class="form-group m-form__group row">
						<div class="form-group m-form__group col-lg-6">
							<label for="name">Full name <span class="colorred">*</span></label>
							<input type="text" class="form-control m-input" name="name" id="name" placeholder="Enter full name"  value="{{ $seller->name }}" >
		                    <span class="help-block text-danger">{{ $errors->first('name') }}</span>
						</div>
						<div class="form-group m-form__group col-lg-6">
							<label for="email">Email address <span class="colorred">*</span></label>
							<input type="email" readonly disabled class="form-control m-input" name="email" id="email" placeholder="Enter email address"  value="{{ $seller->email }}" >
								@if ($errors->has('email'))
								<span class="helpBlock">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
								@endif
						</div>
					</div>
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label for="phone">Phone number <span class="colorred">*</span></label>
							<div class="input-group m-input-group">
								<div class="input-group-prepend">
									<select name="country_code" class="country_code" id="country_code" disabled>
									<option value="+60" @if($seller->country_code == "+60") selected="seleted" @endif> &nbsp;+60 &nbsp;</option>
									<option value="+65" @if($seller->country_code == "+65") selected="seleted" @endif> &nbsp;+65 &nbsp;</option>
								</select></div>
								<input type="text" readonly disabled class="form-control m-input" name="phone" id="phone" placeholder="Enter your phone number"  value="{{ $seller->phone }}" maxlength="12" >
							</div>
							@if ($errors->has('phone'))
									<span class="helpBlock">
										<strong>{{ $errors->first('phone') }}</strong>
									</span>
							@endif
						</div>
						<div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="state">Select State</label>
                                <select class="form-control m-input" name="state">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{$state->name}}" @if($state->name == $seller->state) selected @endif>{{$state->name}}</option>
                                    @endforeach
                                </select>
								<span class="help-block text-danger">{{ $errors->first('state') }}</span>
                            </div>
                        </div>
					</div>
					<div class="form-group m-form__group row">
						<div class="form-group m-form__group col-lg-4">
							<label for="image">Image <span class="colorred">*</span></label>
							<input type="file" class="form-control m-input" id="image" name="image" accept="image/*">
							<span class="help-block text-danger">{{ $errors->first('image') }}</span>
							<input type="hidden" name="old_image" value="{{ $seller->image }}">
						</div>
						@if($seller->image)
							<div class="col-lg-2 form-group m-form__group ">
								<img src="{{ $seller->image }}"  width="100" height="100" style="margin-left: 21px;"/>
							</div>
						@endif
					</div>
                   
					<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit"><br/>
						<div class="m-form__actions m-form__actions--solid">
							<div class="row">
								<div class="col-lg-5">
							</div>
							<div class="col-lg-6">
								<button type="submit" class="btn btn-primary  font12" >Update</button>
								<a href="{{ route('seller.dashboard') }}" class="btn btn-secondary font12">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</form>
	</div>
<script>
	Dropzone.autoDiscover = false;
    $(document).ready(function(){
		var dropzone_image_id = 0;
		var last_dropzone_image_id = 0;
        $("#topBannerDropZonenew").dropzone({
            autoQueue: false,
            maxFilesize: 20,
            acceptedFiles: "jpeg,.jpg,.png,.gif",
            uploadMultiple: false,
            parallelUploads: 5,
            paramName: "file",
            addRemoveLinks: true,
            dictFileTooBig: 'Image is larger than 20MB',
            timeout: 10000,
            init: function() {
                this.on("success", function(file, responseText) {
                });
                this.on("removedfile", function(file) {
                    $(".remove_image_" + file.name.replace(/[\. ,:-]+/g, "_").replace(
                        /[&\/\\#,+()$~%.'":*?<>{}]/g, '_')).first().remove();
                });
                this.on("addedfile", function(file) {
                    var _this = this,
                    reader = new FileReader();
                    reader.onload = function(event) {
                        base64 = event.target.result;
                        _this.processQueue();
                        var hidden_field =
                        "<input hidden type='text' class='remove_image_" + file.name
                        .replace(/[\. ,:-]+/g, "_").replace(
                            /[&\/\\#,+()$~%.'":*?<>{}]/g, '_') +
                        "' name='form[file][" + dropzone_image_id + "]' value=" +
                        base64 + ">";
                        var image = "<img  name='" + file.name + "' src='" + base64 +
                        "' height=100>"
                        $("#image_data").append(hidden_field);

                        dropzone_image_id++;
                    };
                    reader.readAsDataURL(file);
                });
            },
            accept: function(file, done) {
                done();
            }
        });

        $("#lastBannerDropZonenew").dropzone({
            autoQueue: false,
            maxFilesize: 20,
            acceptedFiles: "jpeg,.jpg,.png,.gif",
            uploadMultiple: false,
            parallelUploads: 5,
            paramName: "lastbanner",
            addRemoveLinks: true,
            dictFileTooBig: 'Image is larger than 20MB',
            timeout: 10000,
            init: function() {
                this.on("success", function(banner, responseText) {
                });
                this.on("removedfile", function(banner) {
                    $(".remove_banner_image_" + banner.name.replace(/[\. ,:-]+/g, "_").replace(
                        /[&\/\\#,+()$~%.'":*?<>{}]/g, '_')).first().remove();
                });
                this.on("addedfile", function(banner) {
                    var _this = this,
                    reader = new FileReader();
                    reader.onload = function(event) {
                        base64 = event.target.result;
                        _this.processQueue();
                        var hidden_field =
                        "<input hidden type='text' class='remove_banner_image_" + banner.name
                        .replace(/[\. ,:-]+/g, "_").replace(
                            /[&\/\\#,+()$~%.'":*?<>{}]/g, '_') +
                        "' name='form[lastbanner][" + last_dropzone_image_id + "]' value=" +
                        base64 + ">";
                        var image = "<img  name='" + banner.name + "' src='" + base64 +
                        "' height=100>"
                        $("#banner_image_data").append(hidden_field);

                        last_dropzone_image_id++;
                    };
                    reader.readAsDataURL(banner);
                });
            },
            accept: function(banner, done) {
                done();
            }
        });

        $( "#seller_edit_form" ).validate({
            rules: {
                name: {
                    required: true,
                },
            }, messages: {
                "name" :{
                        required: "Full name is required"
                },
            },
            invalidHandler: function(event, validator) {     
                mUtil.scrollTo("seller_edit_form", -200);
            }
        }); 
		
    });
	function removeimg(id) {
		$('#' + id).css("display", "none");
		var imgs = $('#removeimg').val();
		if (imgs != '') {
			imgs = imgs + ',' + id;
			$('#removeimg').val(imgs);
		} else {
			$('#removeimg').val(id);
		}
	}

	function removebannerimg(id) {
		$('#last_' + id).css("display", "none");
		var imgs = $('#removebanner').val();
		if (imgs != '') {
			imgs = imgs + ',' + id;
			$('#removebanner').val(imgs);
		} else {
			$('#removebanner').val(id);
		}
	}
</script>

@endsection
