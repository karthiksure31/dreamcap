<!-- Center modal content -->
<div class="modal fade editPlayers" id="editPlayersModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myeditPlayersModalLabel">Edit Player</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="updatePlayerForm" method="post" action="{{ route('admin.players.update') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" class="form-control">
                    <div class="form-group">
                        <label for="player_name">Player Name<span class="text-danger">*</span></label>
                        <input type="text" id="player_name" name="player_name" class="form-control" placeholder="Enter Player name">
                    </div>
                    <div class="form-group">
                        <label for="credit_points">Credit Points<span class="text-danger">*</span></label>
                        <input type="number" id="credit_points" max="10" step="0.5" name="credit_points" class="form-control" placeholder="Enter Credit Points">
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
                    <!-- <div class="form-group">
                        <label for="image">Player Image</label>
                        <input type="file" id="image" name="image" class="form-control">
                    </div> -->
                    <div class="form-group">
                        <label for="image">Player Image</label>
                        <input type="file" id="edit_image" name="image" class="form-control-file">
                        <br>
                        <img id="existingPlayerImage" src="" alt="Current Image Logo" style="max-width: 150px; display: none;">
                        <p id="edit_image_name" style="display: none;"></p>
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