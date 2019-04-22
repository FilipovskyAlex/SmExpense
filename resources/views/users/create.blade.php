@extends('layouts.main')

@section('content')
    <div class="row index-users">
        <div class="col-sm-9">
            <h2>{{ trans('app.users-create') }}</h2>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('users.index') }}">
                <button class="btn add-new-user">{{ trans('app.users-index') }}</button>
            </a>
        </div>
    </div>
    <div style="padding-bottom: 40px;" class="row add-new-user-form justify-content-center">
        <div class="col-sm-8">
            <form action="{{ route('users.store') }}" method="post" role="form">
                @csrf

                <input type="hidden" name="company_id" value="{{ \Illuminate\Support\Facades\Auth::user()->company_id }}" />
                <input type="hidden" name="company_name" value="{{ \Illuminate\Support\Facades\Auth::user()->company_name }}" />
                <input type="hidden" name="country" value="{{ \Illuminate\Support\Facades\Auth::user()->country }}" />
                <input type="hidden" name="state" value="{{ \Illuminate\Support\Facades\Auth::user()->state }}" />

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-sm-6">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" autofocus>

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
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">

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
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-sm-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                    <div class="col-sm-6">
                        <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}">

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
                        <input id="city" type="text" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}" autofocus>

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
                        <input id="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" autofocus>

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
                        <input id="post_code" type="text" class="form-control {{ $errors->has('post_code') ? ' is-invalid' : '' }}" name="post_code" value="{{ old('post_code') }}">

                        @if ($errors->has('post_code'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('post_code') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="role" class="col-sm-4 col-form-label text-md-right">{{ __('Role') }}</label>

                    <div class="col-sm-6">
                        <select class="form-control {{ $errors->has('role') ? ' is-invalid' : '' }}" id="role" name="role" onchange="accessabilities((this.value))">
                            <option value="">Choose role</option>
                            @if(isset($roles))
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('role'))
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row" id="accessabilities" style="display: none;">
                    <label for="permission" class="col-sm-4 col-form-label text-md-right">{{ __('Permissions') }}</label>

                    <div class="col-sm-6" style="padding-top: 10px;">
                        @if(isset($companies))
{{--                            Get companies list --}}
                            <ul style="list-style: none; padding-left: 0;">
                                @foreach($companies as $company)
                                    <li><label for=""><input name="access[{{ $company->id }}]" onclick="categories(this, {{ $company->id }})" type="checkbox" value="{{ $company->id }}"> {{ $company->name }}</label></li>
                                    @if(count(\App\Category::getCategoriesByUser($company->id)))
{{--                                        Get categories list --}}
                                        <ul style="list-style: none" id="checkbox_{{ $company->id }}">
                                            @foreach(\App\Category::getCategoriesByUser($company->id) as $category)
                                                <li>
                                                    <label><input class="categories" name="access[{{ $company->id }}][]" type="checkbox" value="{{ $category->id }}"> {{ $category->name }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-sm-4 col-form-label text-md-right">{{ __('Status') }}</label>

                    <div class="col-sm-6">
                        <select class="form-control" id="status" name="status">
                            <option value="1" selected>Active</option>
                            <option value="0">Nonactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-0" style="padding-bottom: 40px;">
                    <div class="col-sm-6 offset-sm-4">
                        <button type="submit" class="btn register-btn">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function categories(e, id) {
            if(e.is("checked")) {

            } else {
                $("#checkbox_" + id).hide();
            }
        }
        
        function accessabilities(role) {
            if(role === '') {
                let attr = $("#accessabilities");
                attr.hide();
            }

            if(role === '1') {
                let attr = $("#accessabilities").attr("type", "checkbox");
                attr.show();
            }

            if(role === '2') {
                $(".categories").attr("type", "checkbox");
                $("#accessabilities").show();
            }

            if(role === '3') {
                $(".categories").attr("type", "radio");
                $("#accessabilities").show();
            }
        }
    </script>
@endsection