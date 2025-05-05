@extends('layouts.admin-layout')
@section('title','Match Schedule')
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
                <h4 class="page-title">Match Schedule</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <!-- <h4 class="header-title">Match Schedule</h4> -->
                <!-- <p class="sub-header"> -->
                <div class="form-group pull-right">
                    <div class="col-xs-2 col-sm-2">
                        <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal" data-target="#addMatchScheduleModal">Add</button>
                    </div>
                </div>
                </p>

                <div class="table-responsive">
                    <table class="table mb-0" id="match-schedules-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Series Name</th>
                                <th>Team 1</th>
                                <th>Team 2</th>
                                <th>Match No</th>
                                <th>Date</th>
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
    @include('admin.match_schedule.add')
    @include('admin.match_schedule.edit')

</div>
<!-- container -->
@endsection
@section('scripts')
<script>
    var getTeamsUrl = "{{ route('admin.get_team.list') }}";
    var getMatchListUrl = "{{ route('admin.match_schedule.list') }}";
    var rowMatchListUrl = "{{ route('admin.match_schedule.rowdetails') }}";
    var deleteMatchScheduleUrl = "{{ route('admin.match_schedule.delete') }}";
    var playerPathUrl = "{{ asset('') }}"; // Ensure the asset URL is correctly formatted
    var defaultImg = "{{ asset('').'/images/users/default.jpg' }}";
    
</script>
<script src="{{ asset('js/custom/match_schedule.js') }}"></script>
@endsection