@extends('auth-layout');

@section('content')
    @section('form-method', 'POST')
    @section('form-action', url('user/register'))
    <h3 class="h3 mb-3 font-weight-normal">Create an account</h3>

    <input type="text" name="name" class="form-control mb-3" value="{{ old('name') }}" placeholder="Name" required autofocus>
    <input type="email" name="email" class="form-control mb-3" value="{{ old('email') }}" placeholder="Email address" required>
    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
    <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Confirm Password">

    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>

    <p class="m-3">--OR--</p>
    <a href="{{ url('user/login') }}" class="btn btn-clear btn-secondary">Login</a>

@endsection

@push('page-css')
<link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">
@endpush
