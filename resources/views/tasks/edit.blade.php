@extends('layout')

@section('content')

<div class="content-area">
    @if(($errors->all()))
        <div class="alert alert-danger mt-3">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif


    <form  method="post" action="{{ url('tasks/edit/'.$task->id) }}">
            @csrf
            @method('PUT')
        <h3 class="h3 mb-3 font-weight-normal">Edit Task</h3>
        <div class="form-group mb-3">
            <label for="" class="control-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $task->title }}" autofocus>
        </div>

        <div class="form-group mb-3">
            <label for="" class="control-label">Content</label>
            <textarea class="form-control" name="content" cols="30" rows="5">{{ $task->content }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="" class="control-label">Due Date</label>
            <input type="text" name="due_date" value="{{ $task->due_date->format('d-m-Y') }}" class="form-control mb-3 date" readonly>
        </div>

        <button class="btn btn-lg btn-primary " type="submit">Update</button>
        <a href="{{ url('tasks') }}" class="btn btn-info btn-lg">View Tasks</a>
    </form>

</div>
@endsection

@push('page-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<style>
    .content-area {
    width: 100%;
    max-width: 500px;
    padding: 15px;
    margin: auto;
    }
</style>
@endpush

@push('page-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
    </script>
@endpush
