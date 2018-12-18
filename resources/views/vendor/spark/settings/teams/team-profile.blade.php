<spark-team-profile :user="user" :team="team" inline-template>
    <div>
        <div v-if="user && team">
            <!-- Update Team Photo -->
            @include('spark::settings.teams.update-team-photo')

            <!-- Update Team Name -->
            @include('spark::settings.teams.update-team-name')
        </div>
        @if (App\TeamSite::where('team_id', $team->id)->count() > 0)

            <div class="card card-default"><div class="card-header">
                    Update Team Site -
                    <button data-toggle="modal" data-target="#sitedns" class="btn btn-link btn-sm pull-right"><i style="color: black;" class="fa fa-info"></i></button>
                    <a class="btn btn-link btn-sm pull-right" href="http://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}"><i style="color: black;" class="fa fa-info"></i> Visit Site</a>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="/updatesite">
                        {{ csrf_field() }}
                        <input id="sitename" type="hidden" class="form-control" name="website_id" value="{{App\TeamSite::where('team_id', $team->id)->first()->website_id}}" required>
                         <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Domain Name</label>
                            <div class="col-md-6">
                                <input id="domainname" type="text" class="form-control" name="domainname" value="{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}" required>
                                <span class="invalid-feedback" style="display: none;">

                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Default Domain Backup</label>
                            <div class="col-md-6">
                                <input id="domainname" type="text" class="form-control" value="{{App\TeamSite::where('team_id', $team->id)->first()->historical_fqdn}}" readonly>
                            </div>

                        </div>

                        <div class="form-group row mb-0"><div class="offset-md-4 col-md-6">
                                <a><button class="btn btn-primary">Set to Default</button></a><button type="submit" class="btn btn-primary">

                                    Update
                                </button></div></div>
                    </form>

                    <h5> </h5>

                </div>
            </div>
            @else
            <div class="card card-default"><div class="card-header">
                    Create Tenant Site
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="/newsite">
                        {{ csrf_field() }}
                        <input id="team_id" type="hidden" class="form-control" name="team_id" value="{{$team->id}}" required autofocus>
                        <div class="form-group hidden">

                            <input id="subname" type="hidden" class="form-control" name="subname" value="{{$team->id}}" required autofocus>
                        </div>
                        <div class="form-group hidden">

                            <div class="col-md-6">
                                <input id="sitename" type="hidden" class="form-control" name="sitename" value="{{$team->name}}" required autofocus>
                                @if ($errors->has('sitename'))
                                    <span class="help-block">
                    <strong>{{ $errors->first('sitename') }}</strong>
                </span>
                                @endif
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-success">Create Site</button>
                        </div>
                    </form>

                </div>
            </div>


        @endif

    </div>

            <div class="modal fade" id="sitedns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        DNS Settings
                    </h5>
                </div>

                <div class="modal-body">
                    <p>Please create an A record for the domain name that you want to use in your DNS panel. It should point to 154.66.198.90 with a maximum TTL of 3600</p>
                </div>

                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{__('No, Go Back')}}</button>

                    <button type="button" class="btn btn-warning" @click="leaveTeam" :disabled="leaveTeamForm.busy">
                        {{__('Yes, Leave')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

</spark-team-profile>
