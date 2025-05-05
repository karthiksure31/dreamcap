<!-- Center modal content -->
<div class="modal fade addTeams" id="addTeamsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myaddTeamsModalLabel">Add Teams</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="addTeamsForm" method="post" action="{{ route('admin.teams.add') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="teams_name">Team Name<span class="text-danger">*</span></label>
                        <input type="text" id="team_name" name="team_name" class="form-control" placeholder="Enter Teams name">
                    </div>
                    <div class="form-group">
                        <label for="team_logo">Team Logo</label>
                        <input type="file" id="team_logo" name="team_logo" class="form-control-file">
                    </div>
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
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" id="classSubmit" class="btn btn-success waves-effect waves-light">Submit</button>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->