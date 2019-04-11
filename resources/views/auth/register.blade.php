@extends('layouts.auth')

@section('authContent')
<div class="row justify-content-center">
    <div class="col-sm-6 register-card">
        <div class="card">
            <div class="card-header" align="center">{{ __('Register') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-sm-6">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-sm-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-sm-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-sm-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-sm-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="country" class="col-sm-4 col-form-label text-md-right">{{ __('Country') }}</label>

                        <div class="col-sm-6">
                            <select id="country" class="form-control" name="country" required>
                                <option>sfd</option>
                                <option>dsd</option>
                                <option>sdsd</option>
                            </select>

                            @if ($errors->has('country'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="state" class="col-sm-4 col-form-label text-md-right">{{ __('State') }}</label>

                        <div class="col-sm-6">
                            <select id="state" class="form-control" name="state" required>
                                <option>sfd</option>
                                <option>dsd</option>
                                <option>sdsd</option>
                            </select>

                            @if ($errors->has('state'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="city" class="col-sm-4 col-form-label text-md-right">{{ __('City') }}</label>

                        <div class="col-sm-6">
                            <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}" required autofocus>

                            @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-sm-4 col-form-label text-md-right">{{ __('Address') }}</label>

                        <div class="col-sm-6">
                            <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus>

                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="post_code" class="col-sm-4 col-form-label text-md-right">{{ __('Post code') }}</label>

                        <div class="col-sm-6">
                            <input id="post_code" type="text" class="form-control" name="post_code" value="{{ old('post_code') }}" required>

                            @if ($errors->has('post_code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('post_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="logo" class="col-sm-4 col-form-label text-md-right">{{ __('Logo') }}</label>

                        <div class="col-sm-6">
                            <input id="logo" type="file" class="form-control" name="logo" value="{{ old('logo') }}" required>

                            @if ($errors->has('logo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-sm-6 offset-sm-4">
                            <button type="submit" class="btn register-btn">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>

                    <p align="center" style="margin-bottom: 0; padding: 20px 0 0 40px">Already have an account?<a href="{{ route('register') }}" style="padding-left: 10px; color: #f62e75; text-decoration: none;">Sign in</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
