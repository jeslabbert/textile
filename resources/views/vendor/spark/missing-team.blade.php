@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="intro mt-5">
                {{--<div class="intro-img">--}}
                    {{--<img src="{{asset('/img/create-team.svg')}}" class="h-90">--}}
                {{--</div>--}}
                {{--<h4>--}}
                    {{--{{__('teams.wheres_your_team')}}--}}
                {{--</h4>--}}
                {{--<p class="intro-copy">--}}
                    {{--{{__('teams.looks_like_you_are_not_part_of_team')}}--}}
                {{--</p>--}}
                <div class="intro-btn">
                    <!-- Pending Invitations -->
                @include('spark::settings.teams.pending-invitations')
                    <!-- Create Team -->
                @if (Spark::createsAdditionalTeams())
                    @include('spark::settings.teams.create-team')
                @endif


                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Current Teams -->
            <div v-if="user && teams.length > 0">
                @include('spark::settings.teams.current-teams')
            </div>
        </div>
    </div>
</div>
@endsection
