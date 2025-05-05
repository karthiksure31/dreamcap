$(function () {
    // rules validation addTeams
    $("#addTeamsForm").validate({
        rules: {
            team_name: "required",
            series_id: "required"
        }
    });

    $('#addTeamsForm').on('submit', function (e) {
        e.preventDefault();
        var addTeamsValid = $("#addTeamsForm").valid();
        if (addTeamsValid === true) {
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
                        $('#teams-table').DataTable().ajax.reload(null, false);
                        $('#addTeamsForm')[0].reset();
                        toastr.success(data.message);
                        $("#addTeamsModal").modal("hide");
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }

    });

    //GET ALL teams
    var teamsTable = $('#teams-table').DataTable({
        processing: true,
        bDestroy: true,
        info: true,
        ajax: teamsListUrl,
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
            data: 'team_name',
            name: 'team_name'
        },
        {
            data: 'team_logo',
            name: 'team_logo'
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
                    var img = row.team_logo ? `${logopath}/${row.team_logo}` : defaultImg;
                    return `
                        <img src="${img}" class="mr-2 rounded-circle" style="width: 40px; height: 40px;">
                        <a href="javascript:void(0);" class="text-body font-weight-semibold">${data}</a>
                    `;
                }
            }
        ]
    }).on('draw', function () { });

    // Edit team
    $(document).on('click', '#editTeamsBtn', function () {
        var id = $(this).data('id');
        $('.editTeams').find('form')[0].reset();
    
        $.post(rowdetailsUrl, { id: id }, function (data) {
            console.log("Data received:", data);
    
            let form = $('.editTeams');
            form.find('input[name="id"]').val(data.details.id);
            form.find('input[name="team_name"]').val(data.details.team_name);
            form.find('select[name="series_id"]').val(data.details.series_id);
    
            if (data.details.team_logo) {
                let imageUrl = logopath + data.details.team_logo;
                $('#existingTeamLogo').attr("src", imageUrl).show();
                $('#edit_team_logo_name').text(data.details.team_logo_name).show();
            } else {
                $('#existingTeamLogo').hide();
                $('#edit_team_logo_name').hide();
            }
    
            $('.editTeams').modal('show');
        }, 'json');
    });
    // update teams
    $("#updateTeamsForm").validate({
        rules: {
            teams_name: "required"
        }
    });

    $('#updateTeamsForm').on('submit', function (e) {
        e.preventDefault();
        var addTeamsValid = $("#updateTeamsForm").valid();
        if (addTeamsValid === true) {
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
                        $('#teams-table').DataTable().ajax.reload(null, false);
                        $('#updateTeamsForm')[0].reset();
                        toastr.success(data.message);
                        $("#editTeamsModal").modal("hide");
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }

    });
    // delete teams
    $(document).on('click', '#deleteTeamsBtn', function () {
        var id = $(this).data('id');
        var url = deleteTeamsUrl;
        swal.fire({
            title: 'Are you sure?',
            html: 'You want to <b>delete</b> this teams',
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
                        $('#teams-table').DataTable().ajax.reload(null, false);
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }, 'json');
            }
        });
    });

});
