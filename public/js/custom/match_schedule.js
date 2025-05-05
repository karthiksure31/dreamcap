$(function () {

    $(".schedule_date").flatpickr({
        enableTime: !0,
        dateFormat: "Y-m-d H:i"
    });
    // change series
    $('#seriesID').on('change', function () {
        var seriesID = $(this).val();
        var IDnames = "#addMatchScheduleForm";
        var team_id_one = null;
        var team_id_two = null;
        getTeams(seriesID, IDnames, team_id_one, team_id_two);
    });
    $('#editseriesID').on('change', function () {
        var seriesID = $(this).val();
        var IDnames = "#updateMatchScheduleForm";
        var team_id_one = null;
        var team_id_two = null;
        getTeams(seriesID, IDnames, team_id_one, team_id_two);
    });
    function getTeams(seriesID, IDnames, team_id_one, team_id_two) {

        $(IDnames).find("#teamIdOne").empty();
        $(IDnames).find("#teamIdOne").append('<option value="">Select Team 1</option>');
        $(IDnames).find("#teamIdTwo").empty();
        $(IDnames).find("#teamIdTwo").append('<option value="">Select Team 2</option>');

        $.post(getTeamsUrl, { series_id: seriesID }, function (res) {
            console.log("dsfds")
            console.log(res)
            $.each(res.details, function (key, val) {
                $(IDnames).find("#teamIdOne").append('<option value="' + val.id + '">' + val.team_name + '</option>');
                $(IDnames).find("#teamIdTwo").append('<option value="' + val.id + '">' + val.team_name + '</option>');
            });
            if (team_id_one && team_id_two) {
                $(IDnames).find('select[name="team_id_one"]').val(team_id_one);
                $(IDnames).find('select[name="team_id_two"]').val(team_id_two);
            }
        }, 'json');
    }
    // rules validation addPlayer
    $("#addMatchScheduleForm").validate({
        rules: {
            series_id: "required",
            team_id_one: "required",
            team_id_two: "required",
            schedule_date: "required",
        }
    });

    $('#addMatchScheduleForm').on('submit', function (e) {
        e.preventDefault();
        var Valid = $("#addMatchScheduleForm").valid();
        if (Valid === true) {
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
                        $('#addMatchScheduleForm')[0].reset();
                        $('#match-schedules-table').DataTable().ajax.reload(null, false);
                        toastr.success(data.message);
                        $("#addMatchScheduleModal").modal("hide");
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }

    });

    //GET ALL 
    $('#match-schedules-table').DataTable({
        processing: true,
        bDestroy: true,
        info: true,
        ajax: getMatchListUrl,
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
            data: 'team_id_one_name',
            name: 'team_id_one_name'
        },
        {
            data: 'team_id_two_name',
            name: 'team_id_two_name'
        },
        {
            data: 'match_no',
            name: 'match_no'
        },
        {
            data: 'schedule_date',
            name: 'schedule_date'
        },
        {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false
        },
        ], columnDefs: [
            {
                "targets": 2,
                "className": "table-user",
                "render": function (data, type, row) {
                    console.log(`${playerPathUrl}/${row.team_logo_one}`);
                    var img = row.team_logo_one ? `${playerPathUrl}/${row.team_logo_one}` : defaultImg;
                    return `
                        <img src="${img}" class="mr-2 rounded-circle" style="width: 40px; height: 40px;">
                        <a href="javascript:void(0);" class="text-body font-weight-semibold">${data}</a>
                    `;
                }
            },
            {
                "targets": 3,
                "className": "table-user",
                "render": function (data, type, row) {
                    console.log(`${playerPathUrl}/${row.team_logo_two}`);
                    var img = row.team_logo_two ? `${playerPathUrl}/${row.team_logo_two}` : defaultImg;
                    return `
                        <img src="${img}" class="mr-2 rounded-circle" style="width: 40px; height: 40px;">
                        <a href="javascript:void(0);" class="text-body font-weight-semibold">${data}</a>
                    `;
                }
            }
        ]
    }).on('draw', function () { });

    // edit player
    $(document).on('click', '#editMatchScheduleBtn', function () {
        var id = $(this).data('id');
        $('.editMatchSchedule').find('form')[0].reset();
        $.post(rowMatchListUrl, {
            id: id
        }, function (data) {

            var seriesID = data.details.series_id;
            var team_id_one = data.details.team_id_one;
            var team_id_two = data.details.team_id_two;
            var IDnames = "#updateMatchScheduleForm";

            getTeams(seriesID, IDnames, team_id_one, team_id_two);

            $('.editMatchSchedule').find('input[name="id"]').val(data.details.id);
            $('.editMatchSchedule').find('input[name="match_no"]').val(data.details.match_no);
            $('.editMatchSchedule').find('input[name="schedule_date"]').val(data.details.schedule_date);
            $('.editMatchSchedule').find('select[name="series_id"]').val(data.details.series_id);

            $('.editMatchSchedule').modal('show');
        }, 'json');
    });
    // update players
    $("#updateMatchScheduleForm").validate({
        rules: {
            series_id: "required",
            team_id_one: "required",
            team_id_two: "required",
            schedule_date: "required",
        }
    });

    $('#updateMatchScheduleForm').on('submit', function (e) {
        e.preventDefault();
        var Valid = $("#updateMatchScheduleForm").valid();
        if (Valid === true) {
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
                        $('#match-schedules-table').DataTable().ajax.reload(null, false);
                        $('#updateMatchScheduleForm')[0].reset();
                        toastr.success(data.message);
                        $("#editMatchScheduleModal").modal("hide");
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        }

    });
    // delete players
    $(document).on('click', '#deleteMatchScheduleBtn', function () {
        var id = $(this).data('id');
        var url = deleteMatchScheduleUrl;
        swal.fire({
            title: 'Are you sure?',
            html: 'You want to <b>delete</b> this match schedule',
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
                        $('#match-schedules-table').DataTable().ajax.reload(null, false);
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                }, 'json');
            }
        });
    });

});
