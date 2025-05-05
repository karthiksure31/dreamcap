<!-- Center modal content -->
<div class="modal fade addMatchSchedule" id="addMatchScheduleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myaddMatchScheduleModalLabel">Add Player</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="addMatchScheduleForm" method="post" action="{{ route('admin.match_schedule.add') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="series_id">Series<span class="text-danger">*</span></label>
                        <select class="form-control" id="seriesID" name="series_id">
                            <option value="">Select Series</option>
                            @forelse ($series as $row)
                            <option value="{{$row->id}}">{{ $row->series_name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="team_id_one">Team 1<span class="text-danger">*</span></label>
                        <select class="form-control" id="teamIdOne" name="team_id_one">
                            <option value="">Select Team 1</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="team_id_two">Team 2<span class="text-danger">*</span></label>
                        <select class="form-control" id="teamIdTwo" name="team_id_two">
                            <option value="">Select Team 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="match_no">Match No</label>
                        <input type="number" id="match_no" name="match_no" class="form-control" placeholder="Enter match no">
                    </div>
                    <div class="form-group">
                        <label for="schedule_date">Schedule Date<span class="text-danger">*</span></label>
                        <input type="text" id="schedule_date" name="schedule_date" class="form-control schedule_date" placeholder="Date and Time">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" id="classSubmit" class="btn btn-success waves-effect waves-light">Submit</button>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->