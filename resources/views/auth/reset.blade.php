@extends('layouts.head')
@section('title', 'Login')
@section('content')

<!-- Our LogIn Register -->
        <section class="our-log bgc-fa">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-6 offset-lg-3">
                        <div class="login_form inner_page">
                            <form method="POST" action="{{ route('reset.post') }}">
                                @csrf     

                                <div class="heading">
                                    <h3 class="text-center">{{ __('messages.Reset password')}}</h3>
                                    
                                </div>
                                    <div class="form-group">
                                         <input id="email" placeholder="{{ __('messages.Email Address')}}" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"autocomplete="email">

                                             @error('email')
                                    <span class="invalid-feedback login-check-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" placeholder="{{ __('messages.Password')}}" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                 @error('password')
                                    <span class="invalid-feedback login-check-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                    </div>
                                
                                <button type="submit" class="btn btn-log btn-block btn-thm2">{{ __('messages.Reset')}}</button>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


@endsection
