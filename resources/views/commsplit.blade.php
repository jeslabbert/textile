
{{--<h3 style="margin-top: 10px;">{{$team->name}}</h3>--}}
{{--<h5>Monthly Subscription: <br> {{$teamplan->price}} € EUR</h5>--}}
<hr>
<div class="row">
    <small class="form-text text-muted col-md-12"> Calculation goes here</small>
</div>
{{--<div class="row" style="padding-left: 15px; padding-right: 15px;">--}}
    {{--<div class="col-md-6" style="padding-left: 15px; padding-right: 15px;">--}}
        {{--<h5 >Total Available Commission: {{$commvalue}} € EUR</h5>--}}
        {{--<small class="form-text text-muted col-md-12"> Calculation goes here</small>--}}
    {{--</div>--}}
    {{--<div class="col-md-6" style="padding-left: 15px; padding-right: 15px;">--}}
        {{--<h5 >Consultants Commission: {{$consvalue}} € EUR</h5>--}}
        {{--<small class="form-text text-muted col-md-12"> Calculation goes here</small>--}}
    {{--</div>--}}

{{--</div>--}}
<hr>
<div class="row" style="padding-left: 15px; padding-right: 15px;">
    <div class="col-md-6">
        <!-- Card -->
        @if(App\TeamCommission::where('team_id', $team->id)->count() > 0)
        <div class="card testimonial-card">

            <!-- Background color -->
            <div class="card-up indigo lighten-1"></div>

            <!-- Avatar -->
            <div class="avatar mx-auto white">
                <img src="{{$firstuser->photo_url}}" style="margin-top: 5px; max-width: 200px;" class="rounded-circle" alt="woman avatar">
            </div>

            <!-- Content -->
            <div class="card-body">
                <!-- Name -->
                <h5 class="card-title">{{$firstuser->name}} {{$firstuser->last_name}}</h5>
                <h6>Support</h6>
                <hr>
                <h6 >Commission: {{$secondvalue}} € EUR</h6>

            </div>
            <div class="rounded-bottom mdb-color lighten-3 text-center pt-3">
                <ul class="list-unstyled list-inline font-small">
                    <li class="list-inline-item pr-2 white-text">
                        @if(App\UserPayout::where('user_id', $firstuser->id)->first())
                            @if(App\UserPayout::where('user_id', $firstuser->id)->first()->verified > 0)
                                <i style="color: green;" class="fa fa-paypal"></i>
                            @elseif(App\UserPayout::where('user_id', $firstuser->id)->first()->verified < 1)
                                <i style="color: red;" class="fa fa-paypal"></i>
                            @endif
                        @else
                            <i style="color: blue;" class="fa fa-paypal"></i>
                        @endif</li>
                </ul>
            </div>

        </div>

        @endif

    </div>
    <div class="col-md-6">
        <!-- Card -->
        @if(App\TeamCommission::where('team_id', $team->id)->count() > 0)
            <div class="card testimonial-card">

                <!-- Background color -->
                <div class="card-up indigo lighten-1"></div>

                <!-- Avatar -->
                <div class="avatar mx-auto white">
                    <img src="{{$seconduser->photo_url}}" class="rounded-circle" style=" margin-top: 5px; max-width: 200px;" alt="woman avatar">
                </div>

                <!-- Content -->
                <div class="card-body">
                    <!-- Name -->
                    <h5 class="card-title">{{$seconduser->name}} {{$seconduser->last_name}}</h5>
                    <h6>Sales</h6>
                    <hr>
                    <h6 >Commission: {{$firstvalue}} € EUR</h6>
                </div>
                <div class="rounded-bottom mdb-color lighten-3 text-center pt-3">
                    <ul class="list-unstyled list-inline font-small">
                        <li class="list-inline-item pr-2 white-text">@if(App\UserPayout::where('user_id', $seconduser->id)->first())
                                @if(App\UserPayout::where('user_id', $seconduser->id)->first()->verified > 0)
                                    <i style="color: green;" class="fa fa-paypal"></i>
                                @elseif(App\UserPayout::where('user_id', $seconduser->id)->first()->verified < 1)
                                    <i style="color: red;" class="fa fa-paypal"></i>
                                @endif
                            @else
                                <i style="color: blue;" class="fa fa-paypal"></i>
                            @endif
                             </li>

                    </ul>
                </div>

            </div>

        @endif

    </div>
</div>




