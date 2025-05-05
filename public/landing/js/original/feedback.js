$(function () {
    $("#submitFeedBack").validate({
        rules: {
            name: "required",
            email: {
                required: true,
                email: true
            },
            feedback: {
                required: true,
                maxlength: 200
            }
        }
    });
    //
    $('#submitFeedBack').on('submit', function (e) {
        e.preventDefault();
        var feedBack = $("#submitFeedBack").valid();
        console.log(feedBack);
        if (feedBack === true) {
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function (response) {
                    if (response.code == 200) {
                        toastr.success(response.message);
                        $('#submitFeedBack')[0].reset();
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }
    });
});