@extends('layouts.main')
@section('title', 'Promotion')
@section('css')
@endsection
@section('content')
<section class="bg-gray pt-4 pb-5">
    <div class="container">
        <div class="row">
{!! $shockingsale->html !!}
</div>
</div>
</section>
@endsection
@section('script')
@endsection
