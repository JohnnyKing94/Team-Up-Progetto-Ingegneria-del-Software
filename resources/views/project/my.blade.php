@extends('layouts.app')

@section('page_title'){{ __('title.project.my.general') }}@endsection

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
                            <table class="table table-striped table-bordered" summary="Projects List as Leader">
                                <thead class="thead-dark ">
                                <tr>
                                    <th scope="col">{{ __('page.project.name') }}</th>
                                    <th scope="col">{{ __('page.project.description') }}</th>
                                    <th scope="col">{{ __('page.project.labels') }}</th>
                                    <th scope="col">{{ __('page.project.leader') }}</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($projects->asLeader) > 0)
                                    @foreach($projects->asLeader as $projectAsLeader)
                                        <tr>
                                            <td>{{$projectAsLeader->name}}</td>
                                            <td class="text-truncate"
                                                style="max-width: 300px;">{{$projectAsLeader->description}}</td>
                                            <td>{{$projectAsLeader->labels}}</td>
                                            <td>{{$projectAsLeader->leader->name . ' ' . \Illuminate\Support\Str::limit($projectAsLeader->leader->surname, 1, $end='.')}}</td>
                                            <td><a href="{{ route('project.show', $projectAsLeader->slug) }}"><em
                                                            class="far fa-eye"></em></a> <a
                                                        href="{{ route('project.edit', $projectAsLeader->slug) }}"><em
                                                            class="far fa-edit"></em></a> <a
                                                        href="" id="confirmDeleteIcon" data-value="{{ route('project.delete', $projectAsLeader->slug) }}" data-toggle="modal"
                                                        data-target="#confirmDeleteModal"><em
                                                            class="fas fa-times"></em></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td align="center" colspan="5">{{ __('field.project.search.noData') }}</td>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <h5 class="card-title">{{ __('title.project.my.teammate') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" summary="Projects List as Teammate">
                                <thead class="thead-dark ">
                                <tr>
                                    <th scope="col">{{ __('page.project.name') }}</th>
                                    <th scope="col">{{ __('page.project.description') }}</th>
                                    <th scope="col">{{ __('page.project.labels') }}</th>
                                    <th scope="col">{{ __('page.project.leader') }}</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($projects->asTeammate) > 0)
                                    @foreach($projects->asTeammate as $projectAsTeammate)
                                        <tr>
                                            <td>{{$projectAsTeammate->name}}</td>
                                            <td class="text-truncate"
                                                style="max-width: 300px;">{{$projectAsTeammate->description}}</td>
                                            <td>{{$projectAsTeammate->labels}}</td>
                                            <td>{{$projectAsTeammate->leader->name . ' ' . \Illuminate\Support\Str::limit($projectAsTeammate->leader->surname, 1, $end='.')}}</td>
                                            <td><a href="{{ route('project.show', $projectAsTeammate->slug) }}"><em class="far fa-eye"></em></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td align="center" colspan="5">{{ __('field.project.search.noData') }}</td>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
