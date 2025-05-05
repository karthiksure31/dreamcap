@extends('layouts.admin-layout')
@section('title','Series')
@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
                <h4 class="page-title">Series</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <!-- <h4 class="header-title">Series</h4> -->
                <!-- <p class="sub-header"> -->
                <div class="form-group pull-right">
                    <div class="col-xs-2 col-sm-2">
                        <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal" data-target="#addSeriesModal">Add Series</button>
                    </div>
                </div>
                </p>

                <div class="table-responsive">
                    <table class="table mb-0" id="series-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Series Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div>
    <!--- end row -->
    @include('admin.series.add')
    @include('admin.series.edit')

</div>
<!-- container -->
@endsection
@section('scripts')
<script>
    var seriesListUrl = "{{ route('admin.series.list') }}";
    var rowdetailsUrl = "{{ route('admin.series.rowdetails') }}";
    var deleteSeriesUrl = "{{ route('admin.series.delete') }}";
</script>
<script src="{{ asset('js/custom/series.js') }}"></script>
@endsection