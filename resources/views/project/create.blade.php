@extends('layouts.app')

@section('page_title')
    {{ __('title.project.create') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('title.project.create') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('project.create') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('field.project.name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('field.project.description') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="10" required autocomplete="description" autofocus>{{ old('description') }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="interests" class="col-md-4 col-form-label text-md-right">{{ __('field.project.labels') }}</label>

                                <div class="col-md-6">
                                    <label>{{ __('field.project.selectMultipleLabels') }}</label>
                                    <select id="labels" multiple class="form-control @error('labels') is-invalid @enderror" name="labels[]" required autocomplete="labels" autofocus>
                                        <option value="Svago" {{  old('labels[]') == 'Svago' ? 'selected' : '' }}>Svago</option>
                                        <option value="Sport" {{ old('labels[]') == 'Sport' ? 'selected' : '' }}>Sport</option>
                                        <option value="Tecnologia" {{ old('labels[]') == 'Tecnologia' ? 'selected' : '' }}>Tecnologia</option>
                                        <option value="Economia" {{ old('labels[]') == 'Economia' ? 'selected' : '' }}>Economia</option>
                                        <option value="Politica" {{ old('labels[]') == 'Politica' ? 'selected' : '' }}>Politica</option>
                                        <option value="Medicina" {{ old('labels[]') == 'Medicina' ? 'selected' : '' }}>Medicina</option>
                                    </select>

                                    @error('labels')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('button.submit.project.create') }}
                                    </button>
                                    <a href="{{ url('/') }}" id="cancel" name="cancel" class="btn btn-default">{{ __('button.cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
