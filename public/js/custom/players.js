$(function () {
    // rules validation addPlayer
    $("#addPlayerForm").validate({
        rules: {
            player_name: "required",
            credit_points: "required",
            series_id: "required",
            team_id: "required",
            position_id: "required"
        }
    });

    $('#addPlayerForm').on('submit', function (e) {
        e.preventDefault();
        var addPlayerValid = $("#addPlayerForm").valid();
        if (addPlayerValid === true) {
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
                        $('#players-table').DataTable().ajax.reload(null, false);
                        $('#addPlayerForm')[0].reset();
                        toastr.success(data.message);
                        $("#addPlayersModal").modal("hide");
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }

    });

    //GET ALL PLAYERS
    var playersTable = $('#players-table').DataTable({
        processing: true,
        bDestroy: true,
        info: true,
        ajax: playerListUrl,
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
            data: 'player_name',
            name: 'player_name'
        },
        {
            data: 'credit_points',
            name: 'credit_points'
        },
        {
            data: 'position_name',
            name: 'position_name'
        },
        {
            data: 'team_name',
            name: 'team_name'
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
        ],
        columnDefs: [
            {
                "targets": 1,
                "className": "table-user",
                "render": function (data, type, row) {
                    console.log(`${playerPathUrl}/${row.image}`);
                    var img = row.image ? `${playerPathUrl}/${row.image}` : defaultImg;
                    return `
                        <img src="${img}" class="mr-2 rounded-circle" style="width: 40px; height: 40px;">
                        <a href="javascript:void(0);" class="text-body font-weight-semibold">${data}</a>
                    `;
                }
            },
            {
                "targets": 4,
                "className": "table-user",
                "render": function (data, type, row) {
                    console.log(`${playerPathUrl}/${row.team_logo}`);
                    var img = row.team_logo ? `${playerPathUrl}/${row.team_logo}` : defaultImg;
                    return `
                        <img src="${img}" class="mr-2 rounded-circle" style="width: 40px; height: 40px;">
                        <a href="javascript:void(0);" class="text-body font-weight-semibold">${data}</a>
                    `;
                }
            }
        ]
    }).on('draw', function () { });

    // edit player
    $(document).on('click', '#editPlayerBtn', function () {
        var id = $(this).data('id');
        $('.editPlayers').find('form')[0].reset();
        $.post(rowdetailsUrl, {
            id: id
        }, function (data) {
            console.log("Data received:", data);
            let form = $('.editPlayers');
            form.find('input[name="id"]').val(data.details.id);
            form.find('input[name="player_name"]').val(data.details.player_name);
            form.find('select[name="series_id"]').val(data.details.series_id);
            form.find('select[name="team_id"]').val(data.details.team_id);
            form.find('select[name="position_id"]').val(data.details.position_id);
            if (data.details.image) {
                let imageUrl = playerPathUrl + data.details.image;
                $('#existingPlayerImage').attr("src", imageUrl).show();
                $('#edit_image_name').text(data.details.image_name).show();
            } else {
                $('#existingPlayerImage').hide();
                $('#edit_image_name').hide();
            }
            form.find('input[name="credit_points"]').val(data.details.credit_points);
            $('.editPlayers').modal('show');
        }, 'json');
    });


    // update players
    $("#updatePlayerForm").validate({
        rules: {
            player_name: "required",
            credit_points: "required",
            series_id: "required",
            team_id: "required",
            position_id: "required"
        }
    });

    $('#updatePlayerForm').on('submit', function (e) {
        e.preventDefault();
        var addPlayerValid = $("#updatePlayerForm").valid();
        if (addPlayerValid === true) {
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
                        $('#players-table').DataTable().ajax.reload(null, false);
                        $('#updatePlayerForm')[0].reset();
                        toastr.success(data.message);
                        $("#editPlayersModal").modal("hide");
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }

    });
    // delete players
    $(document).on('click', '#deletePlayerBtn', function () {
        var id = $(this).data('id');
        var url = deletePlayerUrl;
        swal.fire({
            title: 'Are you sure?',
            html: 'You want to <b>delete</b> this player',
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
                        $('#players-table').DataTable().ajax.reload(null, false);
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }, 'json');
            }
        });
    });

});
