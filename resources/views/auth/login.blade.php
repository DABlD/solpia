@extends('layouts.auth')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">{{ __('Login') }}</div> --}}

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><b>Email Or Username</b></label>

                            <div class="col-md-7">
                                <input id="email" type="text" class="form-control{{ $errors->has('email') || $errors->has('status') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @elseif ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->all()[0] }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><b>{{ __('Password') }}</b></label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-4 align-right">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Login') }}
                                </button>

                                <a href="{{ route('register') }}" class="btn btn-primary pull-right">Register</a>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-styles')
    <style>
        body{
            background-image: url('images/bg.jpg');
			background-size: cover;
			height: 100vh;
        }

        .navbar-laravel{
            background-color: rgba(255, 255, 255, 0);
            border-color: rgba(255, 255, 255, 0);
            box-shadow: none;
        }

        .navbar-brand{
            font-size: 30px;
        }

        .navbar-brand b{
            color: #f0f1f2;
        }

        .navbar-brand b span{
            text-decoration: underline;
        }

        .container{
            max-width: 900px;
        }

        .navbar .container{
            max-width: 90%;
        }

        img{
            width: 130px;
            height: 130px;
            margin-right: 20px;
        }

        .card{
            background-color: rgba(255,255,255,0.3);
            box-shadow: 0px 3px 6px rgba(0,0,0,0.2);
            border-color: #d0d0d0;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
        }

        .align-right{
            text-align: right;
        }

        .form-group label{
            font-family: Nunito,sans-serif;
        }

        .form-group b{
            font-size: 16px;
        }
    </style>
@endpush

@push('after-scripts')
    <script src="{{ asset('js/swal.js') }}"></script>

    <script>
    @if(session('success'))
        swal({
            type: 'success',
            title: '{{ session('success') }}',
            text: 'Wait for your account to be confirmed'
        });
        @php
            session()->forget('success');
        @endphp
    @endif
    </script>
@endpush