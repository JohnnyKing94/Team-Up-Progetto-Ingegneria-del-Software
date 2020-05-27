@extends('layouts.app')

@section('page_title')
    {{ __('title.profile.edit') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('title.profile.edit') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ Auth::user()->email }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.confirmPassword') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('field.name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="surname"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.surname') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text"
                                           class="form-control @error('surname') is-invalid @enderror" name="surname"
                                           value="{{ Auth::user()->surname }}" required autocomplete="surname" autofocus>

                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="birthday"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.birthday') }}</label>

                                <div class="col-md-6">
                                    <input id="birthday" type="date"
                                           class="form-control @error('birthday') is-invalid @enderror" name="birthday"
                                           value="{{ Auth::user()->birthday }}" required autocomplete="birthday" autofocus>

                                    @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gender"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.gender') }}</label>

                                <div class="col-md-6">
                                    <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required autocomplete="gender" autofocus>
                                        <option value="Maschio" {{ Auth::user()->gender == 'Maschio' ? 'selected' : '' }}>Maschio</option>
                                        <option value="Femmina" {{ Auth::user()->gender == 'Femmina' ? 'selected' : '' }}>Femmina</option>
                                        <option value="Non specificato" {{ Auth::user()->gender == 'Non specificato' ? 'selected' : '' }}>Non specificato</option>
                                    </select>

                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="skills"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.skills') }}</label>

                                <div class="col-md-6">
                                <textarea id="skills" class="form-control @error('skills') is-invalid @enderror"
                                          name="skills" required autocomplete="skills"
                                          autofocus>{{ Auth::user()->skills }}</textarea>

                                    @error('skills')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interests"
                                       class="col-md-4 col-form-label text-md-right">{{ __('field.interests') }}</label>

                                <div class="col-md-6">
                                    <label>{{ __('field.selectMultipleInterests') }}</label>
                                    <select id="interests" multiple class="form-control @error('interests') is-invalid @enderror" name="interests[]" required autocomplete="interests" autofocus>
                                        @php
                                            $interests = explode(',', Auth::user()->interests);
                                        @endphp
                                        <option value="Svago" {{ in_array('Svago', $interests) ? 'selected' : '' }}>Svago</option>
                                        <option value="Sport" {{ in_array('Sport', $interests) ? 'selected' : '' }}>Sport</option>
                                        <option value="Tecnologia" {{ in_array('Tecnologia', $interests) ? 'selected' : '' }}>Tecnologia</option>
                                        <option value="Economia" {{ in_array('Economia', $interests) ? 'selected' : '' }}>Economia</option>
                                        <option value="Politica" {{ in_array('Politica', $interests) ? 'selected' : '' }}>Politica</option>
                                        <option value="Medicina" {{ in_array('Medicina', $interests) ? 'selected' : '' }}>Medicina</option>
                                    </select>
                                    @error('interests')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('button.update') }}
                                    </button>
                                </div>
                            </div>
                            @if(session('success'))
                                <br />
                                <div class="alert alert-success">
                                    {{session('success')}}
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
