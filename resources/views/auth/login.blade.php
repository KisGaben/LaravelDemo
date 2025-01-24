@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center flex-column">
        <div class="card shadow-sm mt-5 w-50">
            <div class="card-body">
                <h5 class="card-title text-center">
                    Login
                </h5>
                <form method="post" action="{{route('login')}}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="text" id="email" name="email" value="{{old('email')}}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
        <div class="w-50 mt-2">
            Do not have an account yet? <a href="{{route('register')}}">Create new account</a>
        </div>
    </div>
@endsection
