@extends('layouts.app')

@section('content')
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Organize your tasks!</h1>
            <p class="col-md-8 fs-4">Stay on top of your goals and turn chaos into clarity with our task management solution. Organize your to-dos, prioritize what matters, and achieve more every day—all in one simple, intuitive platform. Start today and take control of your productivity!</p>
            <a class="btn btn-primary btn-lg" type="button" href="{{route('register')}}">Get started!</a>
        </div>
    </div>
@endsection
