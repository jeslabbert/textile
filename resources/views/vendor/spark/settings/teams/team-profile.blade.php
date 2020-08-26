<spark-team-profile :user="user" :team="team" inline-template>
    <div>
        <style>
            .tabcontent-base {
                padding: 6px 12px;
                border: 1px solid #ccc;
                border-top: none;
            }
        </style>
        <div v-if="user && team">
            @if (App\TeamSite::where('team_id', $team->id)->count() > 0)
                <div class="card card-default">
                    <div class="card-header">
                        Visit Site
                        <a class="pull-right" @if(App\TeamSite::where('team_id', $team->id)->first()->https > 0) href="https://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}" @else href="http://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}" @endif target="_blank" data-toggle="tooltip" title="{{__('teams.visit_site')}}"><img src="/url.png" style="width: 30px;"></a>
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
@if(isset($portStage))
                    <div class="card card-default">
                        <div class="card-header">
                            Create Tenant Site
                        </div>
                        <div class="card-body">
                    <div>
                        <h1 class="text-center">
                            Port Setup Step 2
                        </h1>
                        <h2>Save the text on this page, it will not be shown again!</h2>
                        <p>Please log in to your RunCloud account and access the web app you have just created, then follow these steps:</p>
                        <ol>
                            <li>
                                Select NGINX Config
                            </li>
                            <li>Click on Create New Config</li>
                            <li>Choose leave predefined as 'I want to create my own config' and choose location.http as the type</li>
                            <li>In the config name section, type in {{$input['slug']}}</li>
                            <li>
                                Once this is done, under Config Content add the following
                            </li>
                            <code>
                                server {
                                listen          {{$input['site_port']}} ;
                                listen          [::]:{{$input['site_port']}} ;
                                include /etc/nginx-rc/conf.d/{{$input['slug']}}.d/main.conf;

                                # Redirect request to https
                                if ($scheme = http) {
                                # DO NOT REDIRECT TO HTTPS"
                                }
                                }
                            </code>
                        </ol>
                        <form class="form-horizontal" method="POST" action="/runcloud/setup/port2">
                            {{ csrf_field() }}
                            <input id="team_id" type="hidden" class="form-control" name="team_id" value="{{$team->id}}" required autofocus>
                            <input id="subname" type="hidden" class="form-control" name="subname" value="{{$team->id}}" required autofocus>
                            <input id="sitename" type="hidden" class="form-control" name="sitename" value="{{$team->name}}" required autofocus>
                            <input id="siteurl" type="hidden" class="form-control" name="site_url" value="{{$input['site_url']}}">
                            <input id="siteport" type="hidden"  class="form-control" name="site_port" value="{{$input['site_port']}}">
                            <div class="text-center">
                                <button class="btn btn-success" data-toggle="tooltip" title="{{__('teams.create_site')}}">Create Site</button>
                            </div>
                        </form>
                    </div>
                        </div>
                    </div>
                @else
                <div class="card card-default">
                    <div class="card-header">
                        Create Tenant Site
                    </div>
                    <div class="card-body">
                        <!-- Tab links -->
                        <div>
                            <h2>CMSPDF Cloud vs Self Hosted</h2>
                            <p>CMSPDF Cloud explanation</p>
                            <p>Self hosted explanation</p>
                        </div>
                        <div class="tab">
                            <button class="tablinks tablinks-base" onclick="openBase(event, 'cmspdfcloud')"><img src="/cmspdf.png" width="30"><b> CMSPDF</b> <br/>Cloud</button>
                            <button class="tablinks tablinks-base" onclick="openBase(event, 'selfhost')"><img src="/joint2.png" width="65"><br/>Self Hosted</button>
                        </div>
                        <div id="cmspdfcloud" class="tabcontent tabcontent-base" style="padding-top: 15px; display: none;">
                            <div >
                                <h3>Cloud Hosted Subdomain Site</h3>
                                        <p>This will create a subdomain based site off our cloud based hosting. </p>
                                        {{--Domain: yoursite.{{ env('TENANT_EXT') }}--}}
                                    </div>

                                <form class="form-horizontal" method="POST" action="/cloud/setup/new">
                                    {{ csrf_field() }}
                                    <input id="team_id" type="hidden" class="form-control" name="team_id" value="{{$team->id}}" required autofocus>
                                    <div class="form-group hidden">

                                        <input id="subname" type="hidden" class="form-control" name="subname" value="{{$team->id}}" required autofocus>
                                    </div>
                                    <div class="form-group hidden">

                                        <div class="col-md-6">
                                            <input id="sitename" type="hidden" class="form-control" name="sitename" value="{{$team->slug}}" required autofocus>
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
                        <div id="selfhost" class="tabcontent tabcontent-base" style="padding-top: 15px; display: none;">
                            <div>
                                <h3>RunCloud vs Self Managed</h3>
                                <p>RunCloud is a Lightweight Control Panel for Server Management & Zero Downtime Deployment. RunCloud is a faster, secure and modern web server panel that is focused on your web application.</p>
                                <p>Self managed is an option if you would like to completely manage your own server management software integration. This is ideally suited to trained server technicians that can understand the complexities of Ubuntu 18.04, NGINX and MySQL configurations, also known as LEMP stacks.</p>
                            </div>
                            <div class="tab">
                                <button class="tablinks tablinks-self" onclick="openSelf(event, 'runcloud-sub')"><img src="/runcloud-logo.png" style="height: 23px; margin-bottom: 5px; margin-top: 2px;"> <br/>Subdomain Based</button>
                                <button class="tablinks tablinks-self" onclick="openSelf(event, 'runcloud-port')"><img src="/runcloud-logo.png" style="height: 23px; margin-bottom: 5px; margin-top: 2px;"> <br/>Port Based</button>
                                <button class="tablinks tablinks-self" onclick="openSelf(event, 'nginx')"><img src="/nginxfull.png" height="30"><br/>Self Managed</button>
                            </div>
                            <div id="runcloud-sub" class="tabcontent tabcontent-self" style="padding-top: 15px; display: none;">
                                <h3>RunCloud Subdomain Site</h3>
                                <p>If you have set up a server on Runcloud already with a custom username, please make sure to add it under your profile. Once added there, it will appear under the server selection as a location to install your new site to. Alternatively, please view our guide on how to create a server with RunCloud.</p>
                                <p>If you would like a custom server setup without needing RunCloud but require us to manage it for you, please set up a clean Ubuntu box on the service provider of your choice and contact us for the setup. Once set up, you will be able to use it as a RunCloud server on this portal.</p>
                                <form class="form-horizontal" method="POST" action="/runcloud/setup/subdomain">
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
                                                <label for="server_id">Server Selection</label>
                                                <select name="server_id" class="form-control">
                                                    @forelse(App\RuncloudServer::where('type', 2)->get() as $server)
                                                        <option value="{{$server->id}}">{{$server->name}}</option>
                                                    @empty
                                                    @endforelse
                                                    @forelse(App\RuncloudServer::where('user_id', Auth::user()->id)->get() as $server)
                                                        <option value="{{$server->id}}">{{$server->name}}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @if ($errors->has('server_id'))
                                                    <span class="help-block">
                    <strong>{{ $errors->first('server_id') }}</strong>
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
                            <div id="runcloud-port" class="tabcontent tabcontent-self" style="padding-top: 15px; display: none;">
                                <h3>RunCloud Port Based Site</h3>
                                <p>If you have set up a server on Runcloud already with a custom username, please make sure to add it under your profile. Once added there, it will appear under the server selection as a location to install your new site to. Alternatively, please view our guide on how to create a server with RunCloud.</p>
                                <p>If you would like a custom server setup without needing RunCloud but require us to manage it for you, please set up a clean Ubuntu box on the service provider of your choice and contact us for the setup. Once set up, you will be able to use it as a RunCloud server on this portal.</p>
                                <form class="form-horizontal" method="POST" action="/runcloud/setup/port1">
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
                                                <label for="server_id">Server Selection</label>
                                                <select name="server_id" class="form-control">
                                                    @forelse(App\RuncloudServer::where('type', 2)->get() as $server)
                                                        <option value="{{$server->id}}">{{$server->name}}</option>
                                                    @empty
                                                    @endforelse
                                                    @forelse(App\RuncloudServer::where('user_id', Auth::user()->id)->get() as $server)
                                                        <option value="{{$server->id}}">{{$server->name}}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @if ($errors->has('server_id'))
                                                    <span class="help-block">
                    <strong>{{ $errors->first('server_id') }}</strong>
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
                            <div id="nginx" class="tabcontent tabcontent-self" style="padding-top: 15px; display: none;">
                                <div>
                                    <h3>Self Managed</h3>
                                    <p>Self managed is an option if you would like to completely manage your own server management software integration. This is ideally suited to trained server technicians that can understand the complexities of Ubuntu 18.04, NGINX and MySQL configurations, also known as LEMP stacks.</p>
                                    <p>WARNING: This should only be chosen by advanced users who know what they are doing.</p>
                                </div>
                                <div class="tab">
                                    <button class="tablinks tablinks-cloud" onclick="openCloud(event, 'nginx-port')"><img src="/nginxfull.png" height="30"><br/>Port Based</button>
                                    <button class="tablinks tablinks-cloud" onclick="openCloud(event, 'nginx-standard')"><img src="/nginxfull.png" height="30"><br/>Subdomain Based</button>

                                </div>

                                <!-- Tab content -->
                                <div id="nginx-port" class="tabcontent tabcontent-cloud" style="padding-top: 15px; display: none;">
                                    <h3>Self Hosted Port Based Site</h3>

                                    <form class="form-horizontal" method="POST" action="/new-standalone-site-port">
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
                                                    <li>source <(curl -s {{ env('APP_URL') }}/website-install-port.txt)</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-12">
                                                <hr>
                                                <p>If you already have a server set up from before and would like to add a new site. Please run the following:</p>
                                                <ul>
                                                    <li>source <(curl -s {{ env('APP_URL') }}/website-install-port.txt)</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-12">
                                                <hr>
                                                <p>After the above has been completed. Please fill in the details below based on your setup of the website-install command.</p>
                                                <hr>
                                                <p>If you require a standard free SSL, please run the following:</p>
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

                                <div id="nginx-standard" class="tabcontent tabcontent-cloud" style="padding-top: 15px; display: none;">
                                    <h3>Self Hosted Subdomain Site</h3>

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
                                                <p>If you require a standard free SSL, please run the following:</p>
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
                                        </div>

                                        <div class="text-center">
                                            <button class="btn btn-success" data-toggle="tooltip" title="{{__('teams.create_site')}}">Create Site</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>






                    </div>
                </div>
@endif

            @endif




            <!-- Update Team Photo -->
            @include('spark::settings.teams.update-team-photo')

            <!-- Update Team Name -->
            @include('spark::settings.teams.update-team-name')
        </div>
        @if (App\TeamSite::where('team_id', $team->id)->count() > 0)

            <div class="card card-default">
                <div class="card-header">
                    Update Site Security
                    {{--<button data-toggle="modal" data-target="#sitedns" class="btn btn-link btn-sm pull-right"><i style="color: black;" class="fa fa-info"></i></button>--}}
                    {{--<a class="btn btn-link btn-sm pull-right" href="http://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}"><i style="color: black;" class="fa fa-info"></i> Visit Site</a>--}}
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="/updatesitehttps">
                        {{ csrf_field() }}
                        <input id="siteid" type="hidden" class="form-control" name="website_id" value="{{App\TeamSite::where('team_id', $team->id)->first()->website_id}}" required>
                        <input id="sitename" type="hidden" class="form-control" name="website" @if(App\TeamSite::where('team_id', $team->id)->first()->https > 0) value="https://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}" @else value="http://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}" @endif required>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Use HTTPS?</label>
                            <div class="col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    {{--TODO Fix up sizing of input--}}
                                    <input type="hidden" name="https" value="0">
                                    <input type="checkbox" name="https" value="1" @if (App\TeamSite::where('team_id', $team->id)->first()->https > 0) checked @endif style="margin-top: 15px; margin-bottom: 15px;">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                    </form>

                    <h5> </h5>

                </div>
            </div>
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
                        <input id="sitename" type="hidden" class="form-control" name="website" @if(App\TeamSite::where('team_id', $team->id)->first()->https > 0) value="https://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}" @else value="http://{{App\TeamSite::where('team_id', $team->id)->first()->fqdn}}" @endif required>
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
