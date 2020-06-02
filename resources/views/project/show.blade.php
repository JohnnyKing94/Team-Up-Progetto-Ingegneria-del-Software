@extends('layouts.app')

@section('page_title'){{$project->name}} - {{ __('title.project.show') }}@endsection

@section('content')
    <!-- Modal -->
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
                                @if ($alreadySponsored)
                                    @can('own', $project)
                                        <div class="alert alert-danger" role="alert">
                                            {{ __('message.project.sponsor.expirationDate', ['date' => $expirationDate]) }}
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
                                        <a href=""
                                           class="btn btn-dark btn-block">{{$project->leader->name}}</a>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="card-title font-weight-bold text-uppercase">{{ __('page.project.teammates') }}</h5>
                                        <a href="" class="btn btn-light btn-block">Text
                                            will
                                            be added...
                                        </a>
                                        <a href="" class="btn btn-light btn-block">Text
                                            will
                                            be added...
                                        </a>
                                        <a href="" class="btn btn-light btn-block">Text
                                            will
                                            be added...
                                        </a>
                                        <a href="" class="btn btn-light btn-block">Text
                                            will
                                            be added...
                                        </a>
                                        <a href="" class="btn btn-light btn-block">Text
                                            will
                                            be added...
                                        </a>
                                    </div>
                                    @can('own', $project)
                                        <div class="form-group">
                                            <h5 class="card-title font-weight-bold text-uppercase">{{ __('page.project.services.leader') }}</h5>
                                            <a href=""
                                               class="btn btn-info btn-lg btn-block">{{ __('page.project.manageRequests') }}
                                            </a>
                                            <a href="{{ route('project.edit', $project->slug) }}"
                                               class="btn btn-info btn-lg btn-block">{{ __('page.project.edit') }}
                                            </a>
                                            <button class="btn btn-info btn-lg btn-block" data-toggle="modal"
                                                    data-target="#confirmDeleteModal">{{ __('page.project.delete') }}
                                            </button>
                                            <a href="{{ route('project.sponsor', $project->slug) }}"
                                               class="btn btn-info btn-lg btn-block{{ $alreadySponsored ? ' disabled' : '' }}">{{ __('page.project.sponsor') }}
                                            </a>
                                        </div>
                                    @endcan
                                    <div class="form-group">
                                        <h5 class="card-title font-weight-bold text-uppercase">{{ __('page.project.services.general') }}</h5>
                                        <a href=""
                                           class="btn btn-success btn-lg btn-block">{{ __('page.project.chat') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
