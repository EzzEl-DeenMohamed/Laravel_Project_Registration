@extends('layout')
@section('title', 'Home')
@section('content')
<section class="hero">
    <div class="container text-center">
        <h2>{{__('Welcome to our website')}}</h2>
        <p class="lead">{{__('This project is a collage of efforts aimed at discouraging students from studying for their final exams.')}}</p>
    </div>
</section>

@endsection