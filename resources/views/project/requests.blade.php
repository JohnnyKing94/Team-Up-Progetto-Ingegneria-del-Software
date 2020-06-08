@extends('layouts.app')

@section('page_title'){{$project->name}} - {{ __('title.project.join.manage') }}@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('title.project.join.manage') }}</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="form-group row text-uppercase text-center">
                            <div class="col-md-12 h5 font-weight-bold">{{ trans_choice('page.project.requests', count($project->userRequests)) }}</div>
                        </div>
                        <form method="POST" action="{{ route('project.manageRequests', $project->slug) }}">
                            @csrf

                            @foreach($project->userRequests as $userRequest)
                                <div class="form-group row mb-5">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="ml-3 h3 text-uppercase font-weight-bold">
                                                {{ $userRequest->name }} {{ $userRequest->surname }}
                                            </div>
                                            <div class="ml-3 col-form-label">
                                                {{ $userRequest->interests }}
                                            </div>
                                            <div class="ml-auto mr-3 col-form-label">
                                                {{ \Carbon\Carbon::parse($userRequest->pivot->created_at)->locale(Config::get('app.locale'))->formatLocalized('%d/%m/%Y %H:%M:%S') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-form-label font-weight-bold">{{ __('page.project.manageRequests.skills') }}</div>
                                        {{ $userRequest->skills }}
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-form-label font-weight-bold">{{ __('page.project.manageRequests.reason') }}</div>
                                        {{ $userRequest->pivot->reason }}
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button name="accept" value="{{ $userRequest->pivot->identifier }}" type="submit"
                                                class="btn btn-success">{{ __('button.submit.project.request.accept') }}</button>
                                        <button name="decline" value="{{ $userRequest->pivot->identifier }}" type="submit"
                                                class="btn btn-danger">{{ __('button.submit.project.request.decline') }}</button>
                                    </div>
                                </div>
                            @endforeach

                            <div class="form-group row mb-0">
                                <div class="ml-auto mr-3">
                                    <a href="{{ route('project.show', $project->slug) }}" id="back" class="btn btn-default">{{ __('button.back') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
