@extends('layouts.app')

@section('page_title'){{ __('title.project.index') }}@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('title.project.index') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" name="search" id="search" class="form-control" placeholder="{{ __('field.project.search.byName') }}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <select id="labels" multiple class="js-labels-multiple form-control @error('labels') is-invalid @enderror" name="labels[]">
                                    @foreach($labels as $label)
                                        <option value="{{$label}}" {{  collect(old('labels'))->contains($label) == $label ? 'selected' : '' }}>{{$label}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="table-responsive">
                                <h3 align="center">{{ __('field.project.search.totalData') }}: <span id="total_records"></span></h3>
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark ">
                                    <tr>
                                        <th scope="col">{{ __('page.project.name') }}</th>
                                        <th scope="col">{{ __('page.project.description') }}</th>
                                        <th scope="col">{{ __('page.project.labels') }}</th>
                                        <th scope="col">{{ __('page.project.leader') }}</th>
                                        <th></th>
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
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {

            fetchProject();

            function fetchProject(byName = '', byLabel = '') {
                $.ajax({
                    url: "{{ route('project.searchProject') }}",
                    method: 'GET',
                    data: {byName: byName, byLabel: byLabel},
                    dataType: 'json',
                    success: function (data) {
                        $('tbody').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    }
                })
            }

            var timer;
            var ms = 500;
            $('#search, #labels').on('keyup change', function () {
                clearTimeout(timer);
                var byName = $("#search").val();
                var byLabel = $("#labels").val();
                timer = setTimeout(function () {
                    fetchProject(byName, byLabel);
                }, ms);
            });
        });
    </script>
@endpush