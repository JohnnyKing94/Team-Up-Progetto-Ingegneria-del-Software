@extends('layouts.app')

@section('page_title'){{$project->name}} - {{ __('title.project.chat') }}@endsection

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="row card-title">
                <div class="ml-3 h3 text-uppercase font-weight-bolder">{{$project->name}} - {{ __('title.project.chat') }}</div>
                <div class="ml-3 col-form-label">{{$project->labels}}</div>
                <a href="{{ route('project.show', $project->slug) }}" class="btn btn-dark ml-auto">{{ __('button.project.back') }}</a>
            </div>
        </div>
        <chat :user="{{ $user }}" :project="{{ $project }}"></chat>
    </div>
@endsection