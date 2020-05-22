@extends('auth-layout');

@section('content')
    @section('form-method', 'POST')
    @section('form-action', url('user/login'))
    <h3 class="h3 mb-3 font-weight-normal">Please sign in</h3>

    <input type="email" name="email" class="form-control mb-3" value="{{ old('email') }}" placeholder="Email address" required autofocus>
    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

    <p class="m-3">--OR--</p>
    <a href="{{ url('user/register') }}" class="btn btn-clear btn-secondary">Register</a>

@endsection

@push('page-css')
<link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">
@endpush
