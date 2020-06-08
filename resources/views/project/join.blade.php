@extends('layouts.app')

@section('page_title'){{$project->name}} - {{ __('title.project.join.request') }}@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('title.project.join.request') }}</div>

                    <div class="card-body">
                        <div class="form-group row text-uppercase text-center">
                            <div class="col-md-12 h5 font-weight-bold">{{ __('page.project.join.title') }}</div>
                            <div class="col-md-12 h2 font-weight-bolder">{{$project->name}}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 text-center">{{ __('page.project.join.interests') }}:<br/>{{$user->interests}}</div>
                            <div class="col-md-6 text-center">{{ __('page.project.join.labels') }}:<br/>{{$project->labels}}</div>
                        </div>
                        <form method="POST" action="{{ route('project.join.send', $project->slug) }}">
                            @csrf

                            <div class="form-group row mt-4">
                                <label for="reason" class="col-md-4 col-form-label text-md-right">{{ __('field.project.join.reason') }}</label>

                                <div class="col-md-6">
                                    <textarea id="reason" class="form-control @error('reason') is-invalid @enderror" name="reason" rows="10" required
                                              autocomplete="reason" autofocus>{{ old('reason') }}</textarea>

                                    @error('reason')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('button.submit.project.join') }}
                                    </button>
                                    <a href="{{ route('project.show', $project->slug) }}" id="cancel" class="btn btn-default">{{ __('button.cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
