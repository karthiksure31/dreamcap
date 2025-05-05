<!-- Center modal content -->
<div class="modal fade editTeams" id="editTeamsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myeditTeamsModalLabel">Edit Teams</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="updateTeamsForm" method="post" action="{{ route('admin.teams.update') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" class="form-control">
                    <div class="form-group">
                        <label for="team_name">Teams Name<span class="text-danger">*</span></label>
                        <input type="text" id="team_name" name="team_name" class="form-control" placeholder="Enter Teams name">
                    </div>
                    <div class="form-group">
                        <label for="team_logo">Team Logo</label>
                        <input type="file" id="edit_team_logo" name="team_logo" class="form-control-file">
                        <br>
                        <img id="existingTeamLogo" src="" alt="Current Team Logo" style="max-width: 150px; display: none;">
                        <p id="edit_team_logo_name" style="display: none;"></p>
                    </div>
                    <div class="form-group">
                        <label for="series_id">Series<span class="text-danger">*</span></label>
                        <select class="form-control" id="editseriesID" name="series_id">
                            <option value="">Select Series</option>
                            @forelse ($series as $row)
                            <option value="{{$row->id}}">{{ $row->series_name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->