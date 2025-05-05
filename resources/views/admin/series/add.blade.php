<!-- Center modal content -->
<div class="modal fade addSeries" id="addSeriesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myaddSeriesModalLabel">Add Series</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="addSeriesForm" method="post" action="{{ route('admin.series.add') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="series_name">Series Name<span class="text-danger">*</span></label>
                        <input type="text" id="series_name" name="series_name" class="form-control" placeholder="Enter Series name">
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