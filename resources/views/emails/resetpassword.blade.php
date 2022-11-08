@extends('layouts.mail.mail')
@section('title', 'Mrwho')
@section('content')
<div style="padding: 0% 10% 0% 10%;margin: 2% 0% 2% 0%;">
  <p style="text-align: left;">Hello {{ $username }},</p>

  <p style="text-align: justify;">You are receiving this email because we received a password reset request for your account.</p>
  <p style="text-align: justify;">Click below button to reset password.</p>
  <p style="text-align: center;"><a href="{{ $url }}"><button class="btn btn-primary" style="background-color: #da613c; border-color:#ff4700; color: white; height: 40px;">Reset password</button></a></p>
  <p style="text-align: justify;">If you did not request a password reset, no further action is required.</p>
  <p style="text-align: left;"></p>
  <p style="text-align: left;"></p>
  <p></p>
  <p></p>
</div>
@endsection