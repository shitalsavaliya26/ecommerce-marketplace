@extends('seller.layouts.main')
@section('content')
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
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Decoration</span>
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
                        Set Decoration
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
            <form class="m-form m-form--label-align-left- m-form--state-" method="POST"
                action="{{route('seller.shop-decorations.edit')}}" enctype="multipart/form-data" id="decoration_edit">
                <input type="hidden" name="order" id="order">
                {{ csrf_field() }}
                <div class="m-portlet__body">
                    <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-form__section m-form__section--first">
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-4 form-group m-form__group ">
                                            <div class="form-group m-form__group">
                                                <label for="is_variation">Select Content Type <span class="colorred">*</span></label>
                                                <select class="form-control " name="content_type" id="content_type">
                                                    <option value="">Select type of content</option>
                                                    <option value="image">Image</option>
                                                    <option value="product">Product</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 form-group m-form__group ">
                                            <div class="form-group m-form__group">
                                                <a href="javascript:void(0)" class="btn btn-primary btn-send-request font12 mt-3" id="add_content">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="content">
                                        <?php $i = $order;?>
                                        @foreach($shopDecoration as $content)
                                            @if($content->type == 'product')
                                                <div class="form-group m-form__group row">
                                                    <input type="hidden" name="content_id[]" value="{{$content->id}}">
                                                    <div class="col-lg-10">
                                                        <label for="product">Products </label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <select class="form-control m-bootstrap-select m_selectpicker products_ids"
                                                                data-live-search="true" multiple="multiple" required
                                                                name="products_ids[{{$content->id}}][]"  placeholder="Select products">
                                                                @foreach ($products as $product)
                                                                <option value="{{ $product->id }}" @if (in_array($product->id, $content['productIds'])) selected="selected"  @endif>{{ $product->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <a href="javascript:void(0)" class="btn btn-primary btn-send-request font12 mt-3 remove_content">Remove</a>
                                                    </div>
                                                </div>
                                            @elseif($content->type == 'image')
                                                <div class="form-group m-form__group row">
                                                    <input type="hidden" name="content_id[]" value="{{$content->id}}">
                                                    <div class="col-lg-10">
                                                        <label for="product">Images </label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <div class="m-dropzone dropzone m-dropzone--primary dropzoneinit"
                                                                id="decorationDropZonenew_{{$content->id}}" data-id="{{$content->id}}" action="/" method="post">
                                                                <div class="m-dropzone__msg dz-message needsclick">
                                                                    <h3 class="m-dropzone__msg-title">Drop image here</h3>
                                                                    <span class="m-dropzone__msg-desc">Allowed only image
                                                                    files</span>
                                                                </div>
                                                                <div id="image_data"></div>
                                                                <div id="image-holder"></div>
                                                            </div>
                                                            <br>
                                                            @foreach ($content->images as $image)
                                                                <span id="{{ $image->id }}">
                                                                <img src="{{ $image->image }}"
                                                                width="100" height="100" style="margin-left: 21px;" />
                                                                <a onclick="removeimg({{ $image->id }}, {{$content->id}})"
                                                                    m-portlet-tool="remove"
                                                                    class="m-portlet__nav-link m-portlet__nav-link--icon"
                                                                    aria-describedby="tooltip_xr8lyasjaw"
                                                                    style="position: absolute; color: red;text-decoration: none;"><i
                                                                    class="la la-close"></i></a>
                                                                </span>
                                                            @endforeach
                                                            <input type="hidden" name="remove_img[{{$content->id}}]" id="removeimg_{{$content->id}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <a href="javascript:void(0)" class="btn btn-primary btn-send-request font12 mt-3 remove_content">Remove</a>
                                                    </div>
                                                </div>
                                            @endif
                                            <?php $i++;?>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary btn-send-request font12">Submit</button>
                                    <a href="{{ route('seller.shop-decorations.index')}}" class="btn btn-secondary font12">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="product">
            <div class="form-group m-form__group row">
                <div class="col-lg-10">
                    <label for="product">Products </label>
                    <div class="m-input-icon m-input-icon--right">
                        <select class="form-control m-bootstrap-select m_selectpicker products_ids"
                            data-live-search="true" multiple="multiple" required
                            name="products_idsnew[]"  placeholder="Select products">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <a href="javascript:void(0)" class="btn btn-primary btn-send-request font12 mt-3 remove_content">Remove</a>
                </div>
            </div>
        </div>
        <div id="image">
            <div class="form-group m-form__group row">
                <div class="col-lg-10">
                    <label for="product">Images </label>
                    <div class="m-input-icon m-input-icon--right">
                        <div class="m-dropzone dropzone m-dropzone--primary"
                            id="decorationDropZonenew" action="/" method="post">
                            <div class="m-dropzone__msg dz-message needsclick">
                                <h3 class="m-dropzone__msg-title">Drop image here</h3>
                                <span class="m-dropzone__msg-desc">Allowed only image
                                files</span>
                            </div>
                            <div id="image_data"></div>
                            <div id="image-holder"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <a href="javascript:void(0)" class="btn btn-primary btn-send-request font12 mt-3 remove_content">Remove</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        var i = "{{$order}}";
        $('.dropzoneinit').each(function(){
            var id = $(this).attr('data-id');
            dropzone(id);
        });
        $('#content').find('.m_selectpicker').selectpicker();
        $("#product").addClass('hidden').hide();
        $("#image").addClass('hidden').hide();

        $("#add_content").click(function () {
            var div = $(".m_selectpicker");
            var end = $('#content_type :selected').val();
            if(end == 'image') {
                var html = $( "#image" ).html();
                html = html.replace('decorationDropZonenew',"decorationDropZonenew_"+i);
                $('#content').append( html );
                dropzone(i);
            }else if(end == 'product') {
                var html = $( "#product" ).html();
                html = html.replace('products_idsnew[]',"products_idsnew["+i+"][]");
                $('#content').append( html );
            } else {
            }
            $('#content').find('.m_selectpicker').selectpicker();
            i++;
            $('#order').val(i);

        });
        $(document).on('click','.remove_content', function(e) {
            $(this).parent().parent().remove();
        })

        var dropzone_image_id = 0;

        function dropzone(i){
            var myDropzone = new Dropzone("#decorationDropZonenew_"+i,{
                autoQueue: false,
                maxFilesize: 20,
                minFiles: 1,
                acceptedFiles: "jpeg,.jpg,.png,.gif",
                uploadMultiple: false,
                parallelUploads: 5,
                paramName: "file_"+i,
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
                            "' name='form["+i+"][" + dropzone_image_id + "]' value=" +
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
        }

        $( "#decoration_edit" ).validate({
            ignore: ":hidden",
            rules: {
                'products_idsnew[]': {
                    required: true,
                },
                'products_ids[]': {
                    required: true,
                },
            },
            // submitHandler: function(form) {
            //     var imgsrc = $('.dz-image img').attr('src');
            //     if (imgsrc == undefined) {
            //         alert('Please upload product image before submit');
            //     } else {
            //         document.getElementById("decoration_edit").submit();
            //     }
            // }
        });
    });

    function removeimg(id, contentId) {
        $('#' + id).css("display", "none");
        var imgs = $('#removeimg_'+contentId).val();

        if (imgs != '') {
            imgs = imgs + ',' + id;
            $('#removeimg_'+contentId).val(imgs);
        } else {
            $('#removeimg_'+contentId).val(id);
        }
    }
</script>
@endsection
