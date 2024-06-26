@extends('layout')
@section('title', 'Login')
@section('content')
    <div class="container">
        <form class="ms-auto me-auto mt-3" style="width:500px" action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">{{__('Email address')}}</label>
              <input type="email" class="form-control" id="exampleInputEmail1" name="email" >
              <div id="emailHelp" class="form-text">{{__('We\'ll never share your email with anyone else.')}}</div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">{{__('Password')}}</label>
              <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">{{__('Check me out')}}</label>
            </div>
            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
          </form>
    </div>    
@endsection