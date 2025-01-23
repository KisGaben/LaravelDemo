@extends('layouts.app')

@section('content')
    <h1>New task</h1>
    <div class="card shadow-sm mt-5">
        <div class="card-body">
            <h5 class="card-title">
                Create new task
            </h5>
            <form method="post" action="{{route('task.store')}}">
                @csrf
                @method("post")
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" id="title" name="title" value="{{old('title')}}"
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
                              rows="10">{{old('description')}}</textarea>
                    @error('description')
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
