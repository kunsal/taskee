@extends('layout')

@section('content')

<div class="jumbotron jumbotron-fluid">
    <div class="container d-flex flex-column justify-content-around align-items-center">
        <h1 class="display-4 mb-5">Keeping Notes Has Never Been Smarter</h1>
        <p class="lead mb-5">We help you with a smarter way of getting your daily tasks done</p>
    <a href="{{ url('tasks/create') }}" class="btn btn-lg btn-primary">Start Now</a>
    </div>
</div>

@endsection

@push('page-css')
<style>
    .jumbotron {
        background-color: #ccc;
        /* background-image: url('{{url("assets/images/white-note.jpg")}}'); */
        /* min-height: 500px;
        background-position: center left;
        background-size: cover; */
    }
/*
    .jumbotron .container {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-direction: column;
    } */

    .jumbotron .container h1{
        color: #333
    }

    .lead {
        color: #666;
    }
</style>
@endpush
