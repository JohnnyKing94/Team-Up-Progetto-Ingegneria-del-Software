@extends('layouts.app')

@section('page_title')
    {{ __('title.profile.my') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('title.profile.my') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.email') }}</label>

                                <div class="col-md-6 col-form-label">
                                    <strong>{{ Auth::user()->email }}</strong>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.name') }}</label>

                                <div class="col-md-6">
                                    <div class="col-md-6 col-form-label">
                                        <strong>{{ Auth::user()->name }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="surname"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.surname') }}</label>

                                <div class="col-md-6">
                                    <div class="col-md-6 col-form-label">
                                        <strong>{{ Auth::user()->surname }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="birthday"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.birthday') }}</label>

                                <div class="col-md-6">
                                    <div class="col-md-6 col-form-label">
                                        <strong>{{ Auth::user()->birthday }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gender"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.gender') }}</label>

                                <div class="col-md-6">
                                    <div class="col-md-6 col-form-label">
                                        <strong>{{ Auth::user()->gender }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="skills"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.skills') }}</label>

                                <div class="col-md-6">
                                    <div class="col-md-6 col-form-label">
                                        <strong>{{ Auth::user()->skills }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interests"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.interests') }}</label>

                                <div class="col-md-6">
                                    <div class="col-md-6 col-form-label">
                                        <strong>{{ str_replace(',', ', ', Auth::user()->interests) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
