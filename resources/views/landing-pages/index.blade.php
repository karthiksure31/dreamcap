@extends('layouts.landing-layout')
@section('title','dream11 create team')
@section('content')

<div id="matches" class="esport-landing-next-event-section">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <h5 class="esport-landing-header">upcoming matches</h5>
                <!-- LATEST MATCHES BEGIN-->
                <div class="esport-team-landing-latest-matches">
                    @forelse ($match_details as $row)
                    <a href="{{ route('create',[$row->id]) }}">
                        <img src="{{ asset('landing/images/background/row-bg.jpg') }}" alt="background">
                        <!-- <span>Qualification - round 2</span> -->
                        <div>
                            <div class="team left">
                                <span>
                                    <img src="{{ asset($row->team1_logo) }}" alt="team-logo">
                                </span>
                                <span class="team-name">{{ $row->team1 }}</span>
                            </div>
                            <div class="score">
                                <span id="match_count_down">vs</span>
                            </div>
                            <div class="team right">
                                <span class="image">
                                    <img src="{{ asset($row->team2_logo) }}" alt="team-logo">
                                </span>
                                <span class="team-name">{{ $row->team2 }}</span>
                            </div>
                        </div>
                        <!-- <span>full time</span> -->
                    </a>
                    <hr>
                    @empty
                    <p class="text-center" style="color:white">No matches</p>
                    @endforelse
                </div>
                <!-- LATEST MATCHES END-->
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
</div>
@endsection