@extends('layouts.app')

@section('page_title')
    {{ __('title.profile.my') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('title.profile.my') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.edit') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.user.email') }}</label>

                                <div class="col-md-6 col-form-label font-weight-bold">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.user.name') }}</label>

                                <div class="col-md-6 col-form-label font-weight-bold">
                                    {{ Auth::user()->name }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="surname"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.user.surname') }}</label>

                                <div class="col-md-6 col-form-label font-weight-bold">
                                    {{ Auth::user()->surname }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="birthday"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.user.birthday') }}</label>

                                <div class="col-md-6 col-form-label font-weight-bold">
                                    {{ \Carbon\Carbon::parse(Auth::user()->birthday)->locale(Config::get('app.locale'))->formatLocalized('%d/%m/%Y') }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gender"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.user.gender') }}</label>

                                <div class="col-md-6 col-form-label font-weight-bold">
                                    {{ Auth::user()->gender }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="skills"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.user.skills') }}</label>

                                <div class="col-md-6 col-form-label font-weight-bold">
                                    {{ Auth::user()->skills }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interests"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.user.interests') }}</label>

                                <div class="col-md-6 col-form-label font-weight-bold">
                                    {{ str_replace(',', ', ', Auth::user()->interests) }}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
