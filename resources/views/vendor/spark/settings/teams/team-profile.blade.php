<spark-team-profile :user="user" :team="team" inline-template>
    <div>
        <div v-if="user && team">
            @if (App\TeamSite::where('team_id', $team->id)->count() > 0)
                <div class="card card-default">
                    <div class="card-header">
                        Visit Site
                        <a class="pull-right" href="https://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}" target="_blank" data-toggle="tooltip" title="{{__('teams.visit_site')}}"><img src="/url.png" style="width: 30px;"></a>
                        {{--<button data-toggle="modal" data-target="#sitedns" class="btn btn-link btn-sm pull-right"><i style="color: black;" class="fa fa-info"></i></button>--}}
                        {{--<a class="btn btn-link btn-sm pull-right" href="http://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}"><i style="color: black;" class="fa fa-info"></i> Visit Site</a>--}}
                    </div>
                    {{--<div class="card-body">--}}
                        {{--<form class="form-horizontal" method="POST" action="/updatesite">--}}
                            {{--{{ csrf_field() }}--}}
                            {{--<input id="siteid" type="hidden" class="form-control" name="website_id" value="{{App\TeamSite::where('team_id', $team->id)->first()->website_id}}" required>--}}
                            {{--<input id="sitename" type="hidden" class="form-control" name="websitename" value="{{App\TeamSite::where('team_id', $team->id)->first()->website_id}}" required>--}}
                            {{--<div class="form-group row">--}}
                                {{--<label class="col-md-4 col-form-label text-md-right">Domain Name</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>--}}

                                    {{--<div class="input-group mb-2 mr-sm-2">--}}
                                        {{--TODO Fix up sizing of input--}}
                                        {{--<div class="input-group-prepend">--}}
                                            {{--<div class="input-group-text" style="min-height: 38px;"><a href="https://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}" target="_blank" data-toggle="tooltip" title="{{__('teams.visit_site')}}"><i style="color: black;" class="fa fa-link"></i></a></div>--}}
                                        {{--</div>--}}
                                        {{--<input name="domainname" type="text" class="form-control py-0" id="inlineFormInputGroupUsername2" aria-describedby="dnsHelpBlock" placeholder="URL" style="width: auto;">--}}

                                        {{--<small id="dnsHelpBlock" class="form-text text-muted">--}}
                                            {{--An A record for the domain name is needed. It should point to 154.66.198.90--}}
                                        {{--</small>--}}
                                    {{--</div>--}}

                                    {{--<button type="submit" class="btn btn-primary" data-toggle="tooltip" title="{{__('teams.update')}}">Update</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<hr>--}}
                            {{--<div class="form-group row">--}}
                                {{--<label class="col-md-4 col-form-label text-md-right">Default Domain Backup</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<input id="domainname" type="text" class="form-control " value="{{App\TeamSite::where('team_id', $team->id)->first()->historical_fqdn}}" readonly>--}}
                                {{--</div>--}}

                            {{--</div>--}}

                            {{--<div class="form-group row mb-0"><div class="offset-md-4 col-md-6">--}}
                                    {{--<a><button class="btn btn-primary" data-toggle="tooltip" title="{{__('teams.set_to_default')}}">Set to Default</button></a>--}}

                                {{--</div></div>--}}
                        {{--</form>--}}

                        {{--<h5> </h5>--}}

                    {{--</div>--}}
                </div>
                @else

                <div class="card card-default">
                    <div class="card-header">
                        Create Tenant Site
                    </div>
                    <div class="card-body">
                        <!-- Tab links -->
                        <div class="tab">
                            <button class="tablinks" onclick="openCity(event, 'London')">Subdomain Based Site</button>
                            <button class="tablinks" onclick="openCity(event, 'Paris')">Port Based Site</button>

                        </div>

                        <!-- Tab content -->
                        <div id="London" class="tabcontent">
                            <h3>Automated Subdomain Site Creation</h3>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                            <p>This will create a subdomain based site off our cloud based hosting. </p>
                                    {{--Domain: yoursite.{{ env('TENANT_EXT') }}--}}
                                </div>
                            </div>
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
                                    <button class="btn btn-success" data-toggle="tooltip" title="{{__('teams.create_site')}}">Create Site</button>
                                </div>
                            </form>
                        </div>

                        <div id="Paris" class="tabcontent">
                            <h3>Manual Port Site Creation</h3>

                            <form class="form-horizontal" method="POST" action="/new-standalone-site">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>If you require a fresh server installation. Please set up an Ubuntu 18.04 box. Once set up, run the following in order using a SUDO account for the first command.</p>
                                        <ul>
                                            <li>source <(curl -s {{ env('APP_URL') }}/nginx-install.txt)</li>
                                        </ul>
                                            {{--<li>source <(curl -s {{ env('APP_URL') }}/composer-setup.txt)</li>--}}
<hr>
                                            <p>Use the newly created user account for the second command.</p>
                                        <ul>
                                            <li>source <(curl -s {{ env('APP_URL') }}/website-install.txt)</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <p>If you already have a server set up from before and would like to add a new site. Please run the following:</p>
                                        <ul>
                                            <li>source <(curl -s {{ env('APP_URL') }}/website-install.txt)</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <p>After the above has been completed. Please fill in the details below based on your setup of the website-install command.</p>
                                        <hr>
                                        <p>If you require Let's Encrypt SSL, please run the following:</p>
                                        <ul>
                                            <li>source <(curl -s {{ env('APP_URL') }}/SSL-install.txt)</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="siteurl">Site URL</label>
                                            <input id="siteurl" class="form-control" name="site_url">
                                            @if ($errors->has('site_url'))
                                                <span class="help-block">
                    <strong>{{ $errors->first('site_url') }}</strong>
                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="siteport">Site Port</label>
                                            <input id="siteport" class="form-control" type="integer" name="site_port">
                                            @if ($errors->has('site_port'))
                                                <span class="help-block">
                    <strong>{{ $errors->first('site_port') }}</strong>
                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-success" data-toggle="tooltip" title="{{__('teams.create_site')}}">Create Site</button>
                                </div>
                            </form>
                        </div>






                    </div>
                </div>


            @endif




            <!-- Update Team Photo -->
            @include('spark::settings.teams.update-team-photo')

            <!-- Update Team Name -->
            @include('spark::settings.teams.update-team-name')
        </div>
        @if (App\TeamSite::where('team_id', $team->id)->count() > 0)


            <div class="card card-default">
                <div class="card-header">
                    Update Site Details
                    {{--<button data-toggle="modal" data-target="#sitedns" class="btn btn-link btn-sm pull-right"><i style="color: black;" class="fa fa-info"></i></button>--}}
                    {{--<a class="btn btn-link btn-sm pull-right" href="http://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}"><i style="color: black;" class="fa fa-info"></i> Visit Site</a>--}}
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="/updatesitename">
                        {{ csrf_field() }}
                        <input id="siteid" type="hidden" class="form-control" name="website_id" value="{{App\TeamSite::where('team_id', $team->id)->first()->website_id}}" required>
                        <input id="sitename" type="hidden" class="form-control" name="website" value="https://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}" required>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Site Title</label>
                            <div class="col-md-6">
                                <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>

                                <div class="input-group mb-2 mr-sm-2">
                                    {{--TODO Fix up sizing of input--}}

                                    <input name="websitename" @if(App\TeamSite::where('team_id', $team->id)->first()->tenant_sitename != null) value="{{App\TeamSite::where('team_id', $team->id)->first()->tenant_sitename}}" @else placeholder="Custom Title" @endif type="text" class="form-control" id="inlineFormInputGroupUsername2" aria-describedby="dnsHelpBlock" placeholder="Title">

                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                    </form>

                    <h5> </h5>

                </div>
            </div>
            @else



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
