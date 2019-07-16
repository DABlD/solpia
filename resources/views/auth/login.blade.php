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
                            <label for="email" class="col-md-4 col-form-label text-md-right"><b>{{ __('E-mail Address') }}</b></label>

                            <div class="col-md-7">
                                <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
    
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
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

                        {{-- <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-4 align-right">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

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
        }

        .navbar-laravel{
            background-color: rgba(255, 255, 255, 0);
            border-color: rgba(255, 255, 255, 0);
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
            max-width: 30%;
        }

        .navbar .container{
            max-width: 900px;
            box-shadow: none;
        }

        img{
            width: 200px;
            height: 200px;
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