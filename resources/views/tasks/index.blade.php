@extends('layout')

@section('content')

<div class="row">
    <div class="col-12">
        <h2>My Tasks</h2>
    </div>
</div>
    @if(!count($tasks))
        <div class="alert alert-warning">You do not have any task.
            <a href="{{ url('tasks/create') }}"><strong>Click here to create one</strong></a>
        </div>
    @else
<div class="row">
        @foreach($tasks as $task)
            <div class="col-md-4 mb-3">
                <div class="card text-center">
                <div class="card-header text-light {{ $task->done === 0 && $task->due_date->timestamp < time() ? 'bg-danger' : ($task->done === 1 ? 'bg-success' : 'bg-primary')}}">
                        {{ $task->done === 1 ? 'Done' : 'Open'}}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $task->title }}</h5>
                        <p class="card-text">{{ $task->content }}</p>
                        <div class="d-flex flex-row justify-content-around ">
                            <a href="{{ url('tasks/edit/'.$task->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            @if( $task->done === 1)
                                <form method="POST" action="{{ url('tasks/status/'.$task->id.'/open') }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm text-light">Open</button>
                                </form>

                            @else
                            <form method="POST" action="{{ url('tasks/status/'.$task->id.'/done') }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm text-light">Close</button>
                            </form>
                            @endif

                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        Due in {{ $task->due_date->diffForHumans() }}
                    </div>
                </div>
            </div>
            @if($loop->index % 3 === 0) <br /> @endif

        @endforeach
    @endif
</div>

@endsection

@push('page-css')
<style>

</style>
@endpush
