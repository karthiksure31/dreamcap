$(function () {
    var dataSet = [];
    var countPlayers = 0;
    var countWk = 0;
    var countBat = 0;
    var countAll = 0;
    var countBowl = 0;
    var countCreditPoints = 0;
    var countMinMaxTeam1 = 0;
    var countMinMaxTeam2 = 0;
    var playerDetails = [];
    var capVcDetails = [];
    // checked team
    $(".checkedTeam").on("click", function () {

        var checkOrUnchecked = (this.checked ? 'checked' : 'unchecked');
        var rowVal = $(this).val();
        var teamOneID = parseInt($("#teamOneID").val());
        var teamTwoID = parseInt($("#teamTwoID").val());
        var thisID = $(this).attr('id');

        var myArray = rowVal.split("|");

        var points = parseFloat(myArray[1]);
        var position = myArray[2];
        var teamID = parseInt(myArray[3]);

        if (checkOrUnchecked == "checked") {
            $(".showHide").find("#" + thisID).show();
            $(".showHide").find("#" + thisID).prop('checked', false);
            playerDetails.push(thisID);
            // count team players count
            countPlayers += 1;

            $("#totalPlayers").html(countPlayers);
            if (teamID == teamOneID) {
                countMinMaxTeam1 += 1;
            }
            if (teamID == teamTwoID) {
                countMinMaxTeam2 += 1;
            }
            // count team positions
            if (position == "Wk") {
                countWk += 1;
            }
            if (position == "Bat") {
                countBat += 1;
            }
            if (position == "All") {
                countAll += 1;
            }
            if (position == "Bowl") {
                countBowl += 1;
            }
        }
        if (checkOrUnchecked == "unchecked") {
            $(".showHide").find("#" + thisID).hide();
            var Index = playerDetails.indexOf(thisID);
            playerDetails.splice(Index, 1);
            countPlayers -= 1;
            $("#totalPlayers").html(countPlayers);
            // count creadits
            // count team players count
            if (teamID == teamOneID) {
                countMinMaxTeam1 -= 1;
            }
            if (teamID == teamTwoID) {
                countMinMaxTeam2 -= 1;
            }
            // count team positions
            if (position == "Wk") {
                countWk -= 1;
            }
            if (position == "Bat") {
                countBat -= 1;
            }
            if (position == "All") {
                countAll -= 1;
            }
            if (position == "Bowl") {
                countBowl -= 1;
            }
        }

    });
    // click radio
    $(".capRadio input[type=radio][name=captain]").on('click', function () {
        var thisID = $(this).attr('id');
        var vcCheck = $(".vcRadio").find("#" + thisID).is(':checked');
        if (vcCheck) {
            $(".vcRadio").find("#" + thisID).prop('checked', false);
        }
    });
    $(".vcRadio input[type=radio][name=vc_captain]").on('click', function () {
        var thisID = $(this).attr('id');
        var capCheck = $(".capRadio").find("#" + thisID).is(':checked');
        if (capCheck) {
            $(".capRadio").find("#" + thisID).prop('checked', false);
        }
    });
    // generate api
    $("#generateTeam").on("click", function () {

        var totalPlayer = countMinMaxTeam1 + countMinMaxTeam2;

        if (totalPlayer < 11) {
            toastr.warning('You must select at least 11 players');
            return false;
        } else {
            if (countMinMaxTeam1 >= 4 && countMinMaxTeam2 >= 4) {
                if ((countWk > 0) && (countBat >= 3) && (countAll > 0) && (countBowl >= 3)) {
                    var captainVal = $("input[name='captain']:checked").val();
                    var vcCaptainVal = $("input[name='vc_captain']:checked").val();

                    if (captainVal && vcCaptainVal) {
                        capVcDetails = [];
                        capVcDetails.push(captainVal);
                        capVcDetails.push(vcCaptainVal);
                        tempPlayerDetails = playerDetails;
                        tempPlayerDetails = tempPlayerDetails.filter(function (val) {
                            return capVcDetails.indexOf(val) == -1;
                        });
                        var seriesID = $("#seriesID").val();
                        $.ajax({
                            url: createTeamUrl,
                            cache: false,
                            method: 'post',
                            data: {
                                series_id: seriesID,
                                player_details: tempPlayerDetails,
                                cap_vc_details: capVcDetails,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function (response) {

                                $("#captainName").html(response.captain);
                                $("#vcCaptainName").html(response.vc);
                                showDataTable(response.data);
                                toastr.success('Successfully generated by your team');
                            }
                        });

                    } else {
                        toastr.warning('Choose your captain and vice captain');
                        return false;
                    }
                } else {
                    toastr.warning('Select a minimum of 1 wicketkeeper, 3 batsmen, 1 all-rounder, and 4 bowlers');
                    return false;
                }

            } else {
                toastr.warning('Select 4 minimum from one side');
                return false;
            }
        }
    });
    showDataTable(dataSet);
});