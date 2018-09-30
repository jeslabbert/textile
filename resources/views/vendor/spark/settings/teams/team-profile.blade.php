<spark-team-profile :user="user" :team="team" inline-template>
    <div>
        <div v-if="user && team">
            <!-- Update Team Photo -->
            @include('spark::settings.teams.update-team-photo')

            <!-- Update Team Name -->
            @include('spark::settings.teams.update-team-name')
        </div>
        @if (App\TeamSite::where('team_id', $team->id)->count() > 0)
            <a href="http://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}">Visit Site</a>
            <div class="card card-default"><div class="card-header">
                    Update Team Site
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


                        <div class="form-group row mb-0"><div class="offset-md-4 col-md-6"><button type="submit" class="btn btn-primary">

                                    Update
                                </button></div></div>
                    </form>
                    <h5>Default Domain Backup: {{App\TeamSite::where('team_id', $team->id)->first()->historical_fqdn}}</h5>
                    <a><button class="btn btn-primary">Set to Default</button></a>
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
        @if (App\TeamSite::where('team_id', $team->id)->count() > 0)
        <div class="card card-default">
            <div class="card-header">
                Site Billing
            </div>
            <div class="card-body">
                <a href="/sitebilling/{{App\TeamSite::where('team_id', $team->id)->first()->id}}"><button class="btn btn-success">Get Billing</button></a>
            </div>
        </div>
            @endif
    </div>
</spark-team-profile>
