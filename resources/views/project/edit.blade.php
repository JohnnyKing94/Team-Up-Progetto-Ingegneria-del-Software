@extends('layouts.app')

@section('page_title')
    {{$detailProject->name}} - {{ __('title.project.edit') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('title.project.edit') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('project.update', $detailProject->slug)  }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('field.project.name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $detailProject->name }}" required autocomplete="name" autofocus>

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
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" autofocus>{{ $detailProject->description }}</textarea>

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
                                        @php
                                            $labels = explode(',', $detailProject->labels);
                                        @endphp
                                        <option value="Svago" {{ in_array('Svago', $labels) ? 'selected' : '' }}>Svago</option>
                                        <option value="Sport" {{ in_array('Sport', $labels) ? 'selected' : '' }}>Sport</option>
                                        <option value="Tecnologia" {{ in_array('Tecnologia', $labels) ? 'selected' : '' }}>Tecnologia</option>
                                        <option value="Economia" {{ in_array('Economia', $labels) ? 'selected' : '' }}>Economia</option>
                                        <option value="Politica" {{ in_array('Politica', $labels) ? 'selected' : '' }}>Politica</option>
                                        <option value="Medicina" {{ in_array('Medicina', $labels) ? 'selected' : '' }}>Medicina</option>
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
                                        {{ __('button.submit.project.update') }}
                                    </button>
                                </div>
                            </div>
                            @if(session('message'))
                                <br />
                                <div class="alert alert-success">
                                    {{session('message')}}
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
