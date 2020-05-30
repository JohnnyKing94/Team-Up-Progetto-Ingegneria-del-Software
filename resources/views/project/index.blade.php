@extends('layouts.app')

@section('page_title')
    {{ __('title.project.index') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('title.project.index') }}</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark ">
                                <tr>
                                    <th scope="col">{{ __('field.project.name') }}</th>
                                    <th scope="col">{{ __('field.project.description') }}</th>
                                    <th scope="col">{{ __('field.project.labels') }}</th>
                                    <th scope="col">{{ __('field.project.owner') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <td>{{$project->name}}</td>
                                        <td class="text-truncate"
                                            style="max-width: 300px;">{{$project->description}}</td>
                                        <td>{{$project->labels}}</td>
                                        <td>{{$project->leader->name}}</td>
                                        <td><a href="{{ route('project.show', $project->slug) }}"><i
                                                    class="far fa-eye"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
