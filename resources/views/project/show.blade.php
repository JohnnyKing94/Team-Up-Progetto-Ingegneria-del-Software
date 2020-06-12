@extends('layouts.app')

@section('page_title'){{$project->name}} - {{ __('title.project.show') }}@endsection

@section('content')
    @if ($isLeader)
        <!-- Modal Delete Project -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteLabel">{{ __('page.project.modalRemove.title') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ __('page.project.modalRemove.body') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('page.project.modalRemove.cancel') }}</button>
                        <a href="{{ route('project.delete', $project->slug) }}" type="button"
                           class="btn btn-primary">{{ __('page.project.modalRemove.confirm') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($isTeammate)
        <!-- Modal Leave Project-->
        <div class="modal fade" id="confirmLeaveModal" tabindex="-1" role="dialog" aria-labelledby="confirmLeaveLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmLeaveLabel">{{ __('page.project.modalLeave.title') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ __('page.project.modalLeave.body') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('page.project.modalLeave.cancel') }}</button>
                        <a href="{{ route('project.leave', $project->slug) }}" type="button"
                           class="btn btn-primary">{{ __('page.project.modalLeave.confirm') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('title.project.show') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                @if (session('message'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                @if ($isPending)
                                    <div class="alert alert-danger" role="alert">
                                        {{  __('message.project.join.pending') }}
                                    </div>
                                @endif
                                @if ($alreadySponsored)
                                    @can('own', $project)
                                        <div class="alert alert-danger" role="alert">
                                            {{ __('message.project.sponsor.expirationDate', ['date' => \Carbon\Carbon::parse($expirationDate)->locale(Config::get('app.locale'))->addDays(30)->formatLocalized('%d/%m/%Y %H:%M:%S')]) }}
                                        </div>
                                    @endcan
                                    <div class="alert alert-info text-justify" role="alert">
                                        <label class="text-uppercase font-weight-bolder">{{ __('message.project.sponsor.fullMessage') }}</label>
                                        <p>{{ $sponsor->description }}</p>
                                    </div>
                                @endif
                                <div class="row card-title">
                                    <div
                                            class="ml-3 h1 text-uppercase font-weight-bold">{{$project->name}}</div>
                                    <div class="ml-3 mt-2 col-form-label">{{$project->labels}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 mb-5">
                                <div class="mr-2">
                                    <label class="font-weight-bolder">{{ __('page.project.description') }}</label>
                                    <p class="card-text">{{$project->description}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="ml-3">
                                    <div class="form-group">
                                        <h5 class="card-title font-weight-bold text-uppercase">{{ __('page.project.leader') }}</h5>
                                        <button type="button" class="btn btn-dark btn-block">{{$project->leader->name}} {{$project->leader->surname}}</button>
                                    </div>
                                    <div class="form-group">
                                        @if ($isTeammate or $isLeader)
                                            @if (count($project->userTeam) > 0)
                                                <h5 class="card-title font-weight-bold text-uppercase">{{ __('page.project.teammates') }}</h5>
                                                @if ($isLeader)
                                                    <form method="POST" action="{{ route('project.removeTeammate', $project->slug) }}">
                                                        @csrf
                                                        @endif
                                                        @foreach($project->userTeam as $teammate)
                                                            <div class="btn-group mb-2" role="group" style="display: flex; flex: 1;">
                                                                <button type="button" class="btn btn-light btn-block" data-toggle="tooltip" data-placement="right"
                                                                        title="{{ __('page.project.joinDate') }} {{ \Carbon\Carbon::parse($teammate->pivot->date)->locale(Config::get('app.locale'))->formatLocalized('%d/%m/%Y %H:%M:%S') }}">{{ $teammate->name }} {{ $teammate->surname }}
                                                                    @if ($isLeader)
                                                                        <button type="submit" name="removeTeammate" value="{{ $teammate->pivot->identifier }}"
                                                                                class="btn btn-danger"><i class="fa fa-times fa-lg" style="color: white;"></i></button>
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                        @if ($isLeader)
                                                    </form>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                    @if ($isLeader)
                                        <div class="form-group">
                                            <h5 class="card-title font-weight-bold text-uppercase">{{ __('page.project.services.leader') }}</h5>
                                            <a href="{{ route('project.manageRequests', $project->slug) }}"
                                               class="btn btn-info btn-lg btn-block">{{ __('button.project.manageRequests') }}
                                            </a>
                                            <a href="{{ route('project.edit', $project->slug) }}"
                                               class="btn btn-info btn-lg btn-block">{{ __('button.project.edit') }}
                                            </a>
                                            <button type="button" class="btn btn-info btn-lg btn-block" data-toggle="modal"
                                                    data-target="#confirmDeleteModal">{{ __('button.project.delete') }}
                                            </button>
                                            <a href="{{ route('project.sponsor', $project->slug) }}"
                                               class="btn btn-info btn-lg btn-block{{ $alreadySponsored ? ' disabled' : '' }}">{{ __('button.project.sponsor') }}
                                            </a>
                                        </div>
                                    @endif
                                    @if ($isTeammate or $isLeader)
                                        <div class="form-group">
                                            <h5 class="card-title font-weight-bold text-uppercase">{{ __('page.project.services.general') }}</h5>
                                            <a href="{{ route('project.chat', $project->slug) }}"
                                               class="btn btn-success btn-lg btn-block">{{ __('button.project.chat') }}</a>
                                            @if ($isTeammate)
                                                <button type="button" class="btn btn-danger btn-lg btn-block" data-toggle="modal"
                                                        data-target="#confirmLeaveModal">{{ __('button.project.leave') }}
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if (!$isTeammate and !$isLeader)
                            <div class="form-group row mb-0">
                                <div class="col-md-6">
                                    @if (!$isPending)
                                        <a href="{{ route('project.join.send', $project->slug) }}" id="join" name="join"
                                           class="btn btn-primary">{{ __('button.submit.project.join') }}</a>
                                    @endif
                                    @if ($isPending)
                                        <a href="{{ route('project.join.cancel', $project->slug) }}" id="join" name="join"
                                           class="btn btn-primary">{{ __('button.submit.project.cancel') }}</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
