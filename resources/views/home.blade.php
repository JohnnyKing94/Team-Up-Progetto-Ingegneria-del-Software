@extends('layouts.app')

@section('page_title')
    {{ __('title.home') }}
@endsection

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
                    @guest
                            <h1 class="card-title text-center font-weight-bold">Team Up!</h1>
                        @else
                            <h1 class="card-title text-center font-weight-bold">Team Up!</h1>
                            @if (session('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
