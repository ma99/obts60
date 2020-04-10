@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                {{-- <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div> --}}
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('status') }}                    
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
            <div class="card w-75 shadow">
                {{-- <div class="card-header">Verify your phone</div> --}}
                {{-- <img src="{{ asset('images/img/verify-phone.svg') }}" class="card-img-top" alt="..."> --}}
                <div class="card-body">
                    {{-- <h5 class="card-title">Thank You!</h5> --}}
                    <h5 class="card-title ml-3">Phone Verification</h5>
                    <p class="card-text ml-3">A verification code has been sent to your phone.<br>Please enter the code below.</p>

                    {{-- <div class="d-flex justify-content-center"> --}}
                    <div class="d-flex">
                        <div class="col-6">
                            <form method="post" action="{{ route('phoneverification.verify') }}">
                                @csrf
                                <div class="form-group">
                                    {{-- <label for="code">Verification Code</label> --}}
                                    <input id="code" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" type="text" placeholder="Type code here" required autofocus>
                                    @if ($errors->has('code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block">Verify Phone</button>
                                </div>
                            </form>
                            <form method="post" action="{{ route('phoneverification.resend') }}">
                                @csrf                                
                                <div class="form-group">
                                    <button class="btn btn-warning btn-block">Resend Code</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-6 auth-verify">
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection