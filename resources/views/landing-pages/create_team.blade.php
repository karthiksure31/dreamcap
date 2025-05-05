<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="A team is created here based on the combination of players you select, and we recommend good combinations to help you succeed" />
    <meta name="keywords" content="create dream11 team" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>dream11 create team</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat%7COpen+Sans:700,400%7CRaleway:400,800,900" rel="stylesheet" />
    <link rel="icon" href="{{ asset('landing/images/logo/icon.png') }}">
    <script type="text/javascript" src="{{ asset('landing/js/library/jquery.js') }}"></script>
    <link href="{{ asset('landing/css/library/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/css-min/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link href="{{ asset('datatable-css-js/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('datatable-css-js/buttons.dataTables.min.css') }}" rel="stylesheet" />
    <style>
        .error {
            color: red
        }
    </style>
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">

    <style>
        /* checkbox css  */
        input[type="checkbox"] {
            display: none;
        }

        input[type="checkbox"]:hover+label:before {
            opacity: .5;
        }

        .checkbox {
            display: inline-block;
            position: relative;
            padding-left: 40px;
            cursor: pointer;
            color: #111;
            font-weight: 600;
        }

        .checkbox:before {
            z-index: 15;
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 20px;
            border-width: 4px;
            border-style: solid;
            border-color: #444;
            height: 20px;
        }

        input[type="checkbox"]:checked+label {
            color: #000;
        }

        input[type="checkbox"]:checked+label:before {
            border-color: transparent !important;
            border-left-color: #2ecc71 !important;
            border-bottom-color: #2ecc71 !important;
            transform: rotate(-50deg);
            width: 23px !important;
            height: 13px !important;
            top: 3px !important;
        }

        /* radio button  */

        .radio {
            border: 4px solid #ccc;
            border-top-color: #bbb;
            border-left-color: #bbb;
            background: #fff;
            width: 20px;
            height: 30px;
            border-radius: 50%;
        }

        .radio:checked {
            border: 20px solid #4099ff;
        }

        /* spinner */
        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>
</head>

<body>
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <!-- TROPHIES BEGIN-->
    <div class="container">

        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="text pull-right">
                    <a href="{{ route('index') }}" class="btn">Back</a>
                </div>
                <br>
                <br>
                <p><b> Note:</b></p>
                <ol>
                    <li>Captain and Vice-captain by default</li>
                    <li>A minimum of players should be selected: 1 wicket keeper, 3 batsmen, 1 all-rounder, 3 bowlers</li>
                    <li>You will be able to choose a good combination of players based on your choice</li>
                    <li>Based on dream11 credit points, we have a site point system</li>
                    <li>Choose between 12 or 16 players</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="col-md-12 col-sm-12">
                    <!-- <div class="row"> -->
                    <div class="col-md-7 col-sm-7">
                        <h5 class="landing-sport-header" style="color:#337ab7 !important">{{$team_one_name}}</h5>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <p style="padding-top: 32px;color:crimson;">Captain</p>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <p style="padding-top: 32px;color:darkred">Vc</p>
                    </div>
                    <!-- </div> -->
                    <input type="hidden" id="seriesID" value="{{$series_id}}" />
                    <input type="hidden" id="teamOneID" value="{{$team_one_id}}" />
                    @forelse ($team_one as $row)
                    <!-- <div class="row"> -->
                    <div class="col-md-8 col-sm-8">
                        <div class="form-container">
                            <div class="checkbox-container">
                                <input type="checkbox" class="checkedTeam" id="{{$row->id}}" value="{{$row->player_name}}|{{$row->credit_points}}|{{$row->position_name}}|{{$row->team_id}}" />
                                <!-- <label class="checkbox" for="{{$row->id}}">{{$row->player_name}} ({{$row->credit_points}}) {{$row->position_name}}</label> -->
                                <label class="checkbox" for="{{ $row->id }}">
                                    <img src="{{ asset($row->image) }}"
                                        alt="Player Image"
                                        class="player-img"
                                        onerror="this.onerror=null; this.src='{{ asset('images/Default.webp') }}';">
                                    {{ $row->player_name }} ({{ $row->credit_points }}) {{ $row->position_name }}
                                </label>



                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 showHide capRadio">
                        <div>
                            <label><input type="radio" style="display: none;" class="radio" value="{{$row->id}}" id="{{$row->id}}" class="captain" name="captain"></label>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 showHide vcRadio">
                        <div>
                            <label><input type="radio" style="display: none;" class="radio" value="{{$row->id}}" id="{{$row->id}}" class="vc_captain" name="vc_captain"></label>
                        </div>
                    </div>
                    <!-- </div> -->
                    @empty
                    <p>No matches</p>
                    @endforelse
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="col-md-12 col-sm-12">
                    <!-- <div class="row"> -->
                    <div class="col-md-7 col-sm-7">
                        <h5 class="landing-sport-header" style="color:#337ab7 !important">{{$team_two_name}}</h5>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <p style="padding-top: 32px;color:crimson;">Captain</p>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <p style="padding-top: 32px;color:darkred">Vc</p>
                    </div>
                    <!-- </div> -->
                    <input type="hidden" id="teamTwoID" value="{{$team_two_id}}" />
                    @forelse ($team_two as $row)
                    <!-- <div class="row"> -->
                    <div class="col-md-8 col-sm-8">
                        <div class="form-container">
                            <div class="checkbox-container">
                                <input type="checkbox" class="checkedTeam" id="{{$row->id}}" value="{{$row->player_name}}|{{$row->credit_points}}|{{$row->position_name}}|{{$row->team_id}}" />
                                <!-- <label class="checkbox" for="{{$row->id}}">{{$row->player_name}} ({{$row->credit_points}}) {{$row->position_name}}</label> -->
                                <label class="checkbox" for="{{ $row->id }}">
                                    <img src="{{ asset($row->image) }}"
                                        alt="Player Image"
                                        class="player-img"
                                        onerror="this.onerror=null; this.src='{{ asset('images/Default.webp') }}';">
                                    {{ $row->player_name }} ({{ $row->credit_points }}) {{ $row->position_name }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 showHide capRadio">
                        <div>
                            <label><input type="radio" style="display: none;" class="radio" value="{{$row->id}}" id="{{$row->id}}" class="captain" name="captain"></label>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 showHide vcRadio">
                        <div>
                            <label><input type="radio" style="display: none;" class="radio" value="{{$row->id}}" id="{{$row->id}}" class="vc_captain" name="vc_captain"></label>
                        </div>
                    </div>
                    <!-- </div> -->

                    @empty
                    <p>No matches</p>
                    @endforelse
                </div>
            </div>
            <hr>
            <div class="col-md-12 col-sm-12">
                <p style="padding-top: 32px;color:black;"><b>Total Players:</b></p>
                <p id="totalPlayers">0</p>
                <div class="text">
                    <button class="btn" id="generateTeam">Generate</button>
                </div>
            </div>

        </div>
        <br>
        <div class="row text-center align-items-center">
            <div class="col-md-6 col-sm-6">
                <p style="color: crimson; font-weight: bold; margin-bottom: 5px;">Default Captain:</p>
                <div id="captainName"></div>
            </div>
            <div class="col-md-6 col-sm-6">
                <p style="color: darkred; font-weight: bold; margin-bottom: 5px;">Default Vice-Captain:</p>
                <div id="vcCaptainName"></div>
            </div>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table id="teamTable" class="display" width="100%"></table>
            </div>
        </div>
    </div>
    <!-- TROPHIES END-->


    <script>
        var createTeamUrl = "{{ route('create.team') }}";
        var playerPathUrl = "{{ asset('') }}"; // Ensure the asset URL is correctly formatted
    </script>
    <script src="{{ asset('landing/js/original/create-team.js') }}"></script>

    @include('landing-includes.footer')