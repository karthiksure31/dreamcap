$(function () {
    // rules validation addSeries
    $("#addSeriesForm").validate({
        rules: {
            series_name: "required"
        }
    });

    $('#addSeriesForm').on('submit', function (e) {
        e.preventDefault();
        var addSeriesValid = $("#addSeriesForm").valid();
        if (addSeriesValid === true) {
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function (data) {
                    if (data.code == 200) {
                        $('#series-table').DataTable().ajax.reload(null, false);
                        $('#addSeriesForm')[0].reset();
                        toastr.success(data.message);
                        $("#addSeriesModal").modal("hide");
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }

    });

    //GET ALL series
    var seriesTable = $('#series-table').DataTable({
        processing: true,
        bDestroy: true,
        info: true,
        ajax: seriesListUrl,
        "pageLength": 10,
        "aLengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'series_name',
            name: 'series_name'
        },
        {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false
        },
        ]
    }).on('draw', function () { });

    // edit player
    $(document).on('click', '#editSeriesBtn', function () {
        var id = $(this).data('id');
        $('.editSeries').find('form')[0].reset();
        $.post(rowdetailsUrl, {
            id: id
        }, function (data) {

            $('.editSeries').find('input[name="id"]').val(data.details.id);
            $('.editSeries').find('input[name="series_name"]').val(data.details.series_name);
            $('.editSeries').modal('show');
        }, 'json');
    });
    // update series
    $("#updateSeriesForm").validate({
        rules: {
            series_name: "required"
        }
    });

    $('#updateSeriesForm').on('submit', function (e) {
        e.preventDefault();
        var addSeriesValid = $("#updateSeriesForm").valid();
        if (addSeriesValid === true) {
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function (data) {
                    if (data.code == 200) {
                        $('#series-table').DataTable().ajax.reload(null, false);
                        $('#updateSeriesForm')[0].reset();
                        toastr.success(data.message);
                        $("#editSeriesModal").modal("hide");
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }

    });
    // delete series
    $(document).on('click', '#deleteSeriesBtn', function () {
        var id = $(this).data('id');
        var url = deleteSeriesUrl;
        swal.fire({
            title: 'Are you sure?',
            html: 'You want to <b>delete</b> this series',
            showCancelButton: true,
            showCloseButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, Delete',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#556ee6',
            width: 400,
            allowOutsideClick: false
        }).then(function (result) {
            if (result.value) {
                $.post(url, {
                    id: id
                }, function (data) {
                    if (data.code == 200) {
                        $('#series-table').DataTable().ajax.reload(null, false);
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }, 'json');
            }
        });
    });

});
