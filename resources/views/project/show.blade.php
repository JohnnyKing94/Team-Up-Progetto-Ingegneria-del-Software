@extends('layouts.app')

@section('page_title')
    {{$detailProject->name}} - {{ __('title.project.show') }}
@endsection

@section('content')
    <div class="container">
        <div class="card-header">{{ __('title.project.show') }}</div>
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row card-title"><div class="col-5 h1 vw-100 text-uppercase font-weight-bold">{{$detailProject->name}}</div><div class="col-auto col-form-label">{{$detailProject->labels}}</div></div>
                        <label class="font-weight-bold">Descrizione</label>
                        <p class="card-text">{{$detailProject->description}}</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold text-uppercase">Leader</h5>
                        <p class="card-text">{{$detailProject->leader->name}}</p>
                        <h5 class="card-title font-weight-bold text-uppercase">Membri</h5>
                    </div>
                </div>
            </div>
        </div>
@endsection
