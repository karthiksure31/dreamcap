<!-- Center modal content -->
<div class="modal fade addPlayers" id="addPlayersModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myaddPlayersModalLabel">Add Player</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="addPlayerForm" method="post" action="{{ route('admin.players.add') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="player_name">Player Name<span class="text-danger">*</span></label>
                        <input type="text" id="player_name" name="player_name" class="form-control" placeholder="Enter Player name">
                    </div>
                    <div class="form-group">
                        <label for="credit_points">Credit Points<span class="text-danger">*</span></label>
                        <input type="number" id="credit_points" name="credit_points" class="form-control" placeholder="Enter Credit Points" max="10" step="0.5">
                    </div>
                    <div class="form-group">
                        <label for="series_id">Series<span class="text-danger">*</span></label>
                        <select class="form-control" id="series_id" name="series_id">
                            <option value="">Select Series</option>
                            @forelse ($series as $row)
                            <option value="{{$row->id}}">{{ $row->series_name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="team_id">Team<span class="text-danger">*</span></label>
                        <select class="form-control" id="team_id" name="team_id">
                            <option value="">Select Team</option>
                            @forelse ($teams as $row)
                            <option value="{{$row->id}}">{{ $row->team_name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="position_id">Postion<span class="text-danger">*</span></label>
                        <select class="form-control" id="position_id" name="position_id">
                            <option value="">Select Position</option>
                            @forelse ($positions as $row)
                            <option value="{{$row->id}}">{{ $row->position_name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Player Image</label>
                        <input type="file" id="image" name="image" class="form-control">
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