@extends('layouts.app')

@section('page_title'){{ __('title.admin.user.index') }}@endsection

@section('content')
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">{{ __('page.admin.modalRemove.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('page.admin.modalRemove.body') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('page.admin.modalRemove.cancel') }}</button>
                    <a id="confirm" href="" type="button" class="btn btn-primary" name="slug">{{ __('page.admin.modalRemove.confirm') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('title.admin.user.index') }}</div>
                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-success">
                                {{session('message')}}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" summary="Users List">
                                <thead class="thead-dark ">
                                <tr>
                                    <th scope="col">{{ __('field.user.name') }}</th>
                                    <th scope="col">{{ __('field.user.surname') }}</th>
                                    <th scope="col">{{ __('field.user.email') }}</th>
                                    <th scope="col">{{ __('field.user.skills') }}</th>
                                    <th scope="col">{{ __('field.user.interests') }}</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($users) > 0)
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->surname}}</td>
                                            <td>{{$user->email}}</td>
                                            <td class="text-truncate" style="max-width: 200px;">{{$user->skills}}</td>
                                            <td class="text-truncate" style="max-width: 200px;">{{$user->interests}}</td>
                                            <td><a href="{{ route('admin.user.edit', $user->slug) }}"><em class="far fa-edit"></em></a>
                                                <a href="" id="confirmDeleteIcon" data-value="{{ route('admin.user.delete', $user->slug) }}"
                                                   data-toggle="modal"
                                                   data-target="#confirmDeleteModal"><em class="fas fa-times"></em></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td align="center" colspan="5">{{ __('field.admin.user.noData') }}</td>
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