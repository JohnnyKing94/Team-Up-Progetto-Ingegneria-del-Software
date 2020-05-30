@extends('layouts.app')

@section('page_title')
    {{$detailProject->name}} - {{ __('title.project.show') }}
@endsection

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Conferma rimozione</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Sei sicuro di voler rimuovere questo progetto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annula</button>
                    <a href="{{ route('project.delete', $detailProject->slug) }}" type="button" class="btn btn-primary">Conferma</a>
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
                                <div class="row card-title">
                                    <div
                                        class="ml-3 h1 text-uppercase font-weight-bold">{{$detailProject->name}}</div>
                                    <div class="ml-3 mt-2 col-form-label">{{$detailProject->labels}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 mb-5">
                                <div class="mr-2">
                                    <label class="font-weight-bold">Descrizione</label>
                                    <p class="card-text">{{$detailProject->description}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mr-5 ml-5">
                                    <div class="form-group">
                                        <h5 class="card-title font-weight-bold text-uppercase">Leader</h5>
                                        <a href="#"
                                                class="btn btn-dark btn-block">{{$detailProject->leader->name}}</a>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="card-title font-weight-bold text-uppercase">Membri</h5>
                                        <a href="#" class="btn btn-light btn-block">Text
                                            will
                                            be added...
                                        </a>
                                        <a href="#" class="btn btn-light btn-block">Text
                                            will
                                            be added...
                                        </a>
                                        <a href="#" class="btn btn-light btn-block">Text
                                            will
                                            be added...
                                        </a>
                                        <a href="#" class="btn btn-light btn-block">Text
                                            will
                                            be added...
                                        </a>
                                        <a href="#" class="btn btn-light btn-block">Text
                                            will
                                            be added...
                                        </a>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="card-title font-weight-bold text-uppercase">Servizi Leader</h5>
                                        <a href="#" class="btn btn-info btn-lg btn-block">Gestione
                                            richieste
                                        </a>
                                        <a href="{{ route('project.edit', $detailProject->slug) }}" class="btn btn-info btn-lg btn-block">Modifica Progetto
                                        </a>
                                        <button class="btn btn-info btn-lg btn-block" data-toggle="modal" data-target="#confirmDelete">Rimuovi Progetto
                                        </button>
                                        <a href="#" class="btn btn-info btn-lg btn-block">Promuovi
                                        </a>
                                    </div>
                                    <div class="form-group">
                                        <h5 class="card-title font-weight-bold text-uppercase">Servizi Generali</h5>
                                        <a href="#" class="btn btn-success btn-lg btn-block">Chat
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
