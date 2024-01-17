@extends('layouts.head')
@section('title', 'Login')
@section('content')

    <!-- Our LogIn Register -->
        <section class="our-log-reg bgc-fa">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-6 offset-lg-3">
                        <div class="sign_up_form inner_page">
                            <div class="heading">
                                <h3 class="text-center">{{ __('messages.Register to start learning')}}</h3>
                                <p class="text-center">{{ __('messages.Have an account?')}} <a class="text-thm" href="{{ route('auth.login') }}">{{ __('messages.Login')}}</a>
                                </p>
                            </div>
                            <div class="details">
                                <form method="POST" action="{{ route('register.post') }}">
                                    @csrf
                                    <div class="form-group">

                                     <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.Username')}}" autocomplete="name" autofocus>                                        
                                       
                                             @error('name')
                                    <span class="invalid-feedback signup-check-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                         @enderror

                                    </div>
                                    <div class="form-group">
                                         <input id="email" placeholder="{{ __('messages.Email Address')}}" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"autocomplete="email">

                                             @error('email')
                                    <span class="invalid-feedback signup-check-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" placeholder="{{ __('messages.Password')}}" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                 @error('password')
                                    <span class="invalid-feedback signup-check-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                    </div>
                                    <div class="form-group">
                                        <input id="password_confirmation" type="password" placeholder="{{ __('messages.Confirm Password')}}" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                                         @error('password_confirmation')
                                    <span class="invalid-feedback signup-check-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-log btn-block btn-thm2">{{ __('messages.Register')}}</button>
                                    </form>
                                    <div class="divide mt30">
                                        <span class="lf_divider">{{ __('messages.Or')}}</span>
                                        <hr>
                                    </div>
                                    <div class="row mt20">
                                        <div class="col-lg">
                                            <a href="{{ route('social.oauth', 'facebook') }}"><button type="submit" class="btn btn-block color-white bgc-fb mb0"><i
                                                    class="fa fa-facebook f-28 fb-color float-left mt5"></i> {{ __('messages.Facebook')}}</button></a>
                                        </div>
                                        <div class="col-lg">
                                            <a href="{{ route('social.oauth', 'google') }}"><button type="submit"
                                                class="btn btn2 btn-block color-white bgc-gogle mb0"><i
                                                    class="fa fa-google f-28 go-color float-left mt5"></i> {{ __('messages.Google')}}</button></a>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


@endsection
