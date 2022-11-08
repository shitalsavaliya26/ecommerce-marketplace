<!doctype html>
    <html lang="en">

    <head>
        <title>{{ config('app.name', 'Maxshop | Thank you') }}</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{  asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{  asset('assets/bootstrap/css/slick.min.css') }}">

        <style>
            a:hover {
                text-decoration: none;
            }

            .error {
                color: red;
            }
            .center {
              margin: auto;
              width: 50%;
              padding: 10px;
          }
      </style>
      <link rel="stylesheet" href="{{  asset('assets/css/style.css').'?v='.time() }}">
  </head>

  <body>

    <section class="bg-gray pt-4 pb-5">
        <div class="container">
            <div class="row">
                @if (session('error'))
                <h1 class="center"> {{trans('label.your_order_not_processed_due_to')}} {{ session('error') }}. {{trans('label.please_try_again')}}</h1>
                @else
                <h1 class="center"> {{trans('label.thank_you_for_shopping')}}</h1>
                @endif
            </div>

        </div>
    </section>

    <script src="{{ asset('assets/bootstrap/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>