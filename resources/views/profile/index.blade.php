@extends('layouts.main')

@section('content')
    <div class="row profile">
        <div class="col-sm-9">
            <h2>{{ $profile->name }}&nbsp;profile</h2>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('home') }}">
                <button class="btn profile-btn">To homepage<i style="padding-left: 10px;" class="fas fa-arrow-left"></i></button>
            </a>
        </div>
    </div>
    <div class="row justify-content-center edit-profile" style="padding-bottom: 60px;">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    Edit profile
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.edit', $profile->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-sm-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $profile->name }}" autofocus>

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
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $profile->email }}" disabled>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-sm-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-sm-6">
                                <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ $profile->phone }}">

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-sm-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-sm-6">
                                <input id="city" type="text" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ $profile->city }}" autofocus>

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
                                <input id="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ $profile->address }}" autofocus>

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
                                <input id="post_code" type="text" class="form-control {{ $errors->has('post_code') ? ' is-invalid' : '' }}" name="post_code" value="{{ $profile->post_code }}">

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
                                <p style="margin-bottom: 0;"><img src="{{ \App\Providers\CommonProvider::getImage($profile->logo) }}" alt="" width="180px" height="auto" style="padding: 5px 0"></p>

                                <input id="logo" type="file" class="form-control {{ $errors->has('logo') ? ' is-invalid' : '' }}" name="logo">

                                @if ($errors->has('logo'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-6 offset-sm-4">
                                <button type="submit" class="btn profile-btn">
                                    {{ __('Update profile') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center edit-profile" style="padding-bottom: 60px;">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    Edit password
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update', $profile->id) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label text-md-right">{{ __('New password') }}</label>

                            <div class="col-sm-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-sm-4 col-form-label text-md-right">{{ __('Confirm password') }}</label>

                            <div class="col-sm-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-6 offset-sm-4">
                                <button type="submit" class="btn profile-btn">
                                    {{ __('Update password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection