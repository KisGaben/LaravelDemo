@extends('layouts.app')

@section('content')

    <h1>Task #{{$task->id}}</h1>
    <div class="card shadow-sm mt-5">
        <div class="card-body">
            <h5 class="card-title">
                Edit task
            </h5>
            <form method="post" action="{{route('task.update', $task)}}">
                @csrf
                @method("put")
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" id="title" name="title" value="{{old('title', $task->title)}}"
                           class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="10">{{old('description', $task->description)}}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status"
                              class="form-control @error('status') is-invalid @enderror">
                        @foreach($status as $key => $value)
                            <option value="{{$key}}"
                                    @if(old('status', $task->status) == $key) selected @endif
                            >
                                {{$value['title']}}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

@endsection
