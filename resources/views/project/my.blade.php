@extends('layouts.app')

@section('page_title')
    {{ __('title.project.my.general') }}
@endsection

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('page.project.modalRemove.cancel') }}</button>
                    <a id="confirm" href="" type="button" class="btn btn-primary" name="slug">{{ __('page.project.modalRemove.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('title.project.my.general') }}</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ __('title.project.my.leader') }}</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark ">
                                <tr>
                                    <th scope="col">{{ __('field.project.name') }}</th>
                                    <th scope="col">{{ __('field.project.description') }}</th>
                                    <th scope="col">{{ __('field.project.labels') }}</th>
                                    <th scope="col">{{ __('field.project.owner') }}</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projectsAsLeader as $projectLeader)
                                    <tr>
                                        <td>{{$projectLeader->name}}</td>
                                        <td class="text-truncate"
                                            style="max-width: 300px;">{{$projectLeader->description}}</td>
                                        <td>{{$projectLeader->labels}}</td>
                                        <td>{{$projectLeader->leader->name}}</td>
                                        <td><a href="{{ route('project.show', $projectLeader->slug) }}"><i
                                                    class="far fa-eye"></i></a> <a
                                                href="{{ route('project.edit', $projectLeader->slug) }}"><i
                                                    class="far fa-edit"></i></a> <a
                                                href="" id="confirmDeleteIcon" data-value="{{ route('project.delete', $projectLeader->slug) }}" data-toggle="modal" data-target="#confirmDeleteModal"><i
                                                    class="fas fa-times"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h5 class="card-title">{{ __('title.project.my.teammate') }}</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark ">
                                <tr>
                                    <th scope="col">{{ __('field.project.name') }}</th>
                                    <th scope="col">{{ __('field.project.description') }}</th>
                                    <th scope="col">{{ __('field.project.labels') }}</th>
                                    <th scope="col">{{ __('field.project.owner') }}</th>
                                </tr>
                                </thead>
                                <tbody>
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
