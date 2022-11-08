<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Maxshop Seller') }}</title>
  <meta name="description" content="Latest updates and statistic charts">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

  <link href="{{ asset('/vendors/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('/script/style.bundle.css').'?v=' . time() }}" rel="stylesheet" type="text/css" />
  <script src="{{ asset('/vendors/jquery/dist/jquery.js') }}" type="text/javascript"></script>

  <script src="{{ asset('/vendors/vendors.bundle.js') }}"></script>
  <script src="{{ asset('/script/scripts.bundle.js') }}"></script>

  <script src="{{ asset('/vendors/bootbox-master/dist/bootbox.min.js') }}"></script>

  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

  <link href="{{ asset('/css/custom.css?v=' . time()) }}" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="{{ url('public/app/media/img/logos/Favicon.png') }}" />
  <style>
    * {
      font-family: Poppins !important;
    }

    .la,
    .close,
    .check-mark,
    .fc-icon,
    .glyphicon {
      font-family: LineAwesome !important;
    }

    .form-control-feedback {
      color: red;
    }

  </style>
  @yield('css')
</head>

<body class="m-page--fluid m--skin- m-content--skin-dark2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
  <div class="m-grid m-grid--hor m-grid--root m-page">
    @include('seller.layouts.header')
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    @include('seller.layouts.sidebar')
    </div>
      <div class="m-grid__item m-grid__item--fluid m-wrapper">
        @yield('content')
      </div>
  </div>
  @if (!Request::is('home'))
  <script type="text/javascript">
    $(document).ready(function() {
      setTimeout(function() {
        $(".alert-danger").slideUp(500);
      }, 5000);
    });
  </script>
  @endif

  <script type="text/javascript">
    $(document).ready(function() {
      $.validator.addMethod('mindate', function(v, el) {
                // if (this.optional(el)){
                //     return true;
                // }
                if ($("input[name=fromDate]").val() == '') {
                  return true;
                }
                var toDate = $("input[name=toDate]").datepicker('getDate');

                var fromDate = $(el).datepicker('getDate');
                return toDate >= fromDate;
              }, 'From Date must be less then To date');

      $.validator.addMethod('maxdate', function(v, el) {
        if (this.optional(el)) {
          return true;
        }
        if ($("input[name=fromDate]").val() == '') {
          return false;
        }
        var toDate = $("input[name=toDate]").datepicker('getDate');

        var fromDate = $("input[name=fromDate]").datepicker('getDate');
        return toDate >= fromDate;
      }, 'To date must be greater then From date');

      $("#searchForm").validate({
        errorPlacement: function(error, element) {
          error.insertAfter(element.parent('div').parent('div'));
        },
        rules: {
          fromDate: {
            mindate: true,
          },
          toDate: {
            maxdate: true,
          },

        },
        messages: {
          "fromDate": {
            mindate: "From Date must be less then To Date"
          },
          "toDate": {
            maxdate: "To Date must be greater then From Date"
          },

        }
      });

      setTimeout(function() {
        $(".alert-success").slideUp(500);
        $("#app_massges").slideUp(500);
      }, 5000);

      $("#resetButon").click(function() {
        $('#searchForm').find("input, select, textarea").val("");
        $('#searchForm').submit();
        return false;
      });

      $.validator.addMethod("noSpace", function(value, element) {
        return $.trim(value) != "";
      }, "This field is required");

      $.validator.addMethod('mobilenumber', function(value, element, param) {
        if (value == '') {
          return true;
        }
        var country_code = $(param).val();
        if (country_code == '+60') {
          return /^(1)[0-9]{8,}$/.test(value);
        } else {
          return /[6|8|9]\d{7}|\+65[6|8|9]\d{7}|\+65\s[6|8|9]\d{7}$/.test(value);
        }
      }, 'Enter must be a valid phone number.');
    });
  </script>

  <script src="{{ asset('/js/select2.js') }}" type="text/javascript"></script>
  @yield('scripts')
  <script type="text/javascript">
    jQuery(document).ready(function($) {
            //add placeholder through the script
            $("#m_select2_3, #m_select2_3_validate").select2({
              placeholder: "Select a postcode"
            })
          });

    jQuery(document).ready(function($) {
            //add placeholder through the script
            $("#m_select3_3, #m_select3_3_validate").select2({
              placeholder: "Select shipping company"
            })
            $(document).on('submit', 'form', function() {
              $('button').attr('disabled', 'disabled');
            });
          });

    jQuery(document).ready(function($) {
            //add placeholder through the script
            $("#customer_users, #agent_users").select2({
              placeholder: "Select a users",
              closeOnSelect: false,
              allowHtml: true,
              allowClear: true,
              tags: true
            })
          });

    function iformat(icon, badge, ) {
      var originalOption = icon.element;
      var originalOptionBadge = $(originalOption).data('badge');

      return $('<span><i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text +
        '<span class="badge">' + originalOptionBadge + '</span></span>');
    }
  </script>
</body>
</html>
