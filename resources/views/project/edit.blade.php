@extends('layouts.app')

@section('page_title'){{$project->name}} - {{ __('title.project.edit') }}@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('title.project.edit') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('project.edit', $project->slug)  }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('field.project.name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $project->name }}" required autocomplete="name" autofocus>

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
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="10" required autocomplete="description" autofocus>{{ $project->description }}</textarea>

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
                                    <select id="labels" multiple class="js-labels-multiple form-control @error('labels') is-invalid @enderror" name="labels[]" required autocomplete="labels" autofocus>
                                        @php
                                            $selectedLabels = explode(',', $project->labels);
                                        @endphp
                                        @foreach($labels as $label)
                                            <option value="{{$label}}" {{ in_array($label, $selectedLabels) ? 'selected' : '' }}>{{$label}}</option>
                                        @endforeach
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
                                    <a href="{{ route('project.show', $project->slug) }}" id="cancel" name="cancel" class="btn btn-default">{{ __('button.cancel') }}</a>
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
