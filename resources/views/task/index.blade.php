@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Tasks</h1>
        @can('create', App\Models\Task::class)
            <a href="{{route('task.create')}}" class="btn btn-primary">New task</a>
        @endcan
    </div>
    <div class="row mt-5">
        @foreach($tasks as $task)
            <div class="col-12 col-sm-6 col-lg-4">
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
                        <div class="d-flex gap-2">
                            <a href="{{route('task.show', $task)}}" class="btn btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
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
                </div>
            </div>
        @endforeach
@endsection
