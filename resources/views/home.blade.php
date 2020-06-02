@extends('layouts.app')

@section('page_title'){{ __('title.home') }}@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('title.home') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <h1 class="card-title text-center font-weight-bold">Team Up! <i class="fas fa-folder-open"></i>
                        </h1>
                        <h5 class="text-center"><strong>Team Up!</strong> vuole andare incontro a tutte le persone che hanno dovuto rinunciare o hanno riscontrato difficoltà nel
                            realizzare i loro progetti, cercando di riunire persone con lo stesso obbiettivo o passione in modo tale da potersi aiutare a vicenda.</h5>
                        @guest
                            <div class="card mt-4">
                                <div class="card-body">
                                    <p class="card-text float-left mt-3"><a href="{{ route('login') }}" class="btn btn-primary">Accedi ora</a> e usufruisci di questo servizio
                                        gratuito!</p>
                                    <p class="card-text float-right mt-3">Cosa??? Non sei ancora registrato? <a href="{{ route('register') }}" class="btn btn-dark">Fallo ora!</a>
                                    </p>
                                </div>
                            </div>
                        @else
                            @if(count($sponsors) > 0)
                                <div class="card text-white bg-dark mt-3 mb-3">
                                    <div class="card-header text-uppercase">{{ __('page.home.sponsor.header') }}</div>
                                    <div class="card-body">
                                        <h5 class="card-title text-center">{{ __('page.home.sponsor.body') }}</h5>
                                        <div id="carouselSponsorCaptions" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                @foreach($sponsors as $sponsor)
                                                    <li data-target="#carouselSponsorCaptions" data-slide-to="{{ $loop->index }}"
                                                        class="{{ $loop->index == 0 ? 'active' : '' }}"></li>
                                                @endforeach
                                            </ol>
                                            <div class="carousel-inner">
                                                @foreach($sponsors as $sponsor)
                                                    <div class="carousel-item{{ $loop->index == 0 ? ' active' : '' }}">
                                                        <div class="sponsorCarousel"></div>
                                                        <a href="{{ route('project.show', $sponsor->project->slug) }}">
                                                        <div class="carousel-caption d-none d-md-block">
                                                            <h3 class="text-uppercase font-weight-bolder">{{ $sponsor->project->name }}</h3>
                                                            <h5>{{ $sponsor->title }}</h5>
                                                            <p class="text-truncate">{{ $sponsor->description }}</p>
                                                        </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselSponsorCaptions" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselSponsorCaptions" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
