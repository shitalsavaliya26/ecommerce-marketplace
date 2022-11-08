@extends('layouts.main')

@section('title',  $page->title ?? "")

@section('css')
<style>
    p img {
        max-width: 100%;
    }
</style>
@endsection

@section('content')
    <section class="bg-gray pt-2 pb-5">
        <div class="container">
            <div class="mt-4 bg-white br-15 py-3 px-sm-3 shadow">
                <h5 style="text-align: center;"><b>{!! $page->title ?? "" !!}</b></h5> <br>
                {!! $page->description ?? "" !!}
            </div>
        </div>
    </section>
@endsection