@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Task #{{$task->id}}</h1>
        <div class="d-flex align-items-center gap-2">
            @if($task->status != App\Models\Task::DONE)
                @php
                    $next = $task->status == App\Models\Task::NEW ? App\Models\Task::IN_PROGRESS : App\Models\Task::DONE;
                @endphp
                <form method="post"
                      action="{{route('task.status',$task)}}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="{{$next}}">
                    <input type="submit" class="btn btn-outline-primary"
                           value="{{$status[$next]['title']}}"/>
                </form>
                <a href="{{route('task.edit', $task)}}" class="btn btn-outline-warning">
                    <i class="bi bi-pencil"></i>
                </a>
            @endif
            <form method="post"
                  action="{{route('task.destroy',$task)}}">
                @csrf
                @method('delete')
                <button type="submit" name="delete" class="btn btn-outline-danger">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="row mt-5">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">
                    {{$task->title}}
                </h5>
                <h6 class="card-subtitle mb-2 {{$status[$task->status]['class']}}">
                    {{$status[$task->status]['title']}}
                </h6>
                <p class="card-text">
                    {{$task->description}}
                </p>
            </div>
        </div>
    </div>
@endsection
