@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card shadow-sm mt-5 w-50">
            <div class="card-body">
                <h5 class="card-title text-center">
                    Register account
                </h5>
                <form method="post" action="{{route('register')}}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name"
                               class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="text" id="email" name="email"
                               class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password"
                               class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Password confirmation</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
    </div>
@endsection
