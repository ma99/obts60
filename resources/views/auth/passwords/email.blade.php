@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card border-0 shadow">
            
                <div class="card-header bg-info text-white">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row my-2">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                      <div class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                      </div>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4 my-3">
                                <button type="submit" class="btn btn-warning btn-block">
                                    {{ __('Send Password Reset Link') }}
                                </button>                                
                            </div>
                            <div class="col-md-6 offset-md-4">
                                @if (Route::has('password.request.phone'))
                                    <a class="btn btn-light text-primary btn-block btn-sm" href="{{ route('password.request.phone') }}">
                                        {{ __('Reset Password by Phone?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
