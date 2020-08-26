<spark-profile :user="user" inline-template>
    <div>
        <!-- Update Profile Photo -->
        @include('spark::settings.profile.update-profile-photo')
        <!-- Update Contact Information -->
        @include('settings.profile.update-profile-details')

        @include('spark::settings.profile.update-contact-information')

        <div role="tabcard" class="tab-pane active" id="runcloud">
            <div class="card card-default">
                <div class="card-header">{{__('Runcloud Servers')}}</div>

                <div class="card-body">
                    <!-- Success Message -->
<h4>Servers</h4>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-valign-middle mb-0">
                            <thead>
                            <th class="th-lg">{{__('Name')}}</th>
                            {{--<th>{{__('Owner')}}</th>--}}
                            <th>&nbsp;</th>
                            </thead>

                            <tbody>
                            @forelse(App\RuncloudServer::where('type', 2)->get() as $server)
                                <tr>
                                    <!-- Team Name -->
                                    <td>
                                        <div class="btn-table-align">
                                            {{$server->name}}
                                        </div>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <div class="btn-table-align">
                                            N/A
                                        </div>
                                    </td>

                                </tr>
                            @endforelse
                            @forelse(App\RuncloudServer::where('user_id', Auth::user()->id)->get() as $server)
                            <tr>
                                <!-- Team Name -->
                                <td>
                                    <div class="btn-table-align">
                                        {{$server->name}}
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <button class="btn btn-danger">Delete</button>
                                </td>


                            </tr>
                            @empty
                                <tr>
                                    <td>
                                        <div class="btn-table-align">
                                            N/A
                                        </div>
                                    </td>

                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>



                    <hr>
<h4>Add Additional Server</h4>
                    <form style="margin:auto;" method="POST" action="/profile/addserver">
                        {{ csrf_field() }}
                        <input type="text" name="user_id" value="{{Auth::user()->id}}" hidden>
                        <!-- E-Mail Address -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Type')}}</label>

                            <div class="col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    {{--                                                    <div class="input-group-prepend">--}}
                                    {{--                                                        <div class="input-group-text" style="    min-height: 38px;"><i class="fa fa-paypal"></i> </div>--}}
                                    {{--                                                    </div>--}}
                                    <select name="type" class="form-control">
                                        <option value="1">Self Hosted Runcloud</option>
                                        <option value="2">CMSPDF Runcloud</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('IP Address')}}</label>

                            <div class="col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    {{--                                                    <div class="input-group-prepend">--}}
                                    {{--                                                        <div class="input-group-text" style="    min-height: 38px;"><i class="fa fa-paypal"></i> </div>--}}
                                    {{--                                                    </div>--}}
                                    <input type="text" name="ip_address" class="form-control" placeholder="127.0.0.1">
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Server ID')}}</label>

                            <div class="col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    {{--                                                    <div class="input-group-prepend">--}}
                                    {{--                                                        <div class="input-group-text" style="    min-height: 38px;"><i class="fa fa-paypal"></i> </div>--}}
                                    {{--                                                    </div>--}}
                                    <input type="text" name="server_id" class="form-control" placeholder="1270121">
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Server Name')}}</label>

                            <div class="col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    {{--                                                    <div class="input-group-prepend">--}}
                                    {{--                                                        <div class="input-group-text" style="    min-height: 38px;"><i class="fa fa-paypal"></i> </div>--}}
                                    {{--                                                    </div>--}}
                                    <input type="text" name="name" class="form-control" placeholder="Username">
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Username')}}</label>

                            <div class="col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    {{--                                                    <div class="input-group-prepend">--}}
                                    {{--                                                        <div class="input-group-text" style="    min-height: 38px;"><i class="fa fa-paypal"></i> </div>--}}
                                    {{--                                                    </div>--}}
                                    <input type="text" name="server_user" class="form-control" placeholder="Username">
                                </div>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Password')}}</label>

                            <div class="col-md-6">
                                <div class="input-group mb-2 mr-sm-2">
                                    {{--                                                    <div class="input-group-prepend">--}}
                                    {{--                                                        <div class="input-group-text" style="    min-height: 38px;"><i class="fa fa-paypal"></i> </div>--}}
                                    {{--                                                    </div>--}}
                                    <input type="text" name="server_password" class="form-control" placeholder="Username">
                                </div>

                            </div>
                        </div>

                        <!-- Update Button -->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">

                                    {{__('Update')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</spark-profile>
