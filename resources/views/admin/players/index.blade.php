@extends('layouts.admin-layout')
@section('title','Players')
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
                <h4 class="page-title">Players</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <!-- <h4 class="header-title">Players</h4> -->
                <!-- <p class="sub-header"> -->
                <div class="form-group pull-right">
                    <div class="col-xs-2 col-sm-2">
                        <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal" data-target="#addPlayersModal">Add Player</button>
                    </div>
                </div>
                </p>

                <div class="table-responsive">
                    <table class="table mb-0" id="players-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Player Name</th>
                                <th>Credit Points</th>
                                <th>Position Name</th>
                                <th>Team Name</th>
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
    @include('admin.players.add')
    @include('admin.players.edit')

</div>
<!-- container -->
@endsection
@section('scripts')
<script>
    var playerListUrl = "{{ route('admin.players.list') }}";
    var rowdetailsUrl = "{{ route('admin.players.rowdetails') }}";
    var deletePlayerUrl = "{{ route('admin.players.delete') }}";
    var playerPathUrl = "{{ asset('') }}"; // Ensure the asset URL is correctly formatted
    var defaultImg = "{{ asset('').'/images/users/default.jpg' }}";
</script>
<script src="{{ asset('js/custom/players.js') }}"></script>
@endsection