@extends('spark::layouts.app')

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mousetrap/1.4.6/mousetrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection

@section('navextra')
    <button class="openbtn" onclick="openNav()">&#9776;</button>
@endsection

@section('sidebar')
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <aside>
            <h3 class="nav-heading " style="margin-left:10px;">
                {{__('Kiosk')}}
            </h3>
            <ul class="nav flex-column mb-4 ">
                <li class="nav-item ">
                    <a class="nav-link" style="display: flex;" href="/spark/kiosk" aria-controls="Back" role="tab" data-toggle="tab" onclick="closeNav()">
                        <svg class="icon-20 " style="padding-right:5px;" viewBox="0 0 20 20 " xmlns="http://www.w3.org/2000/svg ">
                            <path style="fill:#bababa;" d="M10 20C4.4772 20 0 15.5228 0 10S4.4772 0 10 0s10 4.4772 10 10-4.4772 10-10 10zm0-17C8.343 3 7
              4.343 7 6v2c0 1.657 1.343 3 3 3s3-1.343 3-3V6c0-1.657-1.343-3-3-3zM3.3472 14.4444C4.7822 16.5884 7.2262 18 10
              18c2.7737 0 5.2177-1.4116 6.6528-3.5556C14.6268 13.517 12.3738 13 10 13s-4.627.517-6.6528 1.4444z "></path>
                        </svg>
                        {{__('Back')}}
                    </a>
                </li>
            </ul>
        </aside>
    </div>
@endsection
@section('content')
<spark-kiosk :user="user" inline-template>
    <div class="spark-screen container">
        <div class="row">
            <!-- Tabs -->

            <!-- Tab cards -->
            <div class="col-md-12">
                <div class="tab-content">
                    <!-- Announcements -->
                    <div role="tabcard" class="tab-pane" id="announcements">
                        @include('spark::kiosk.announcements')
                    </div>

                    <!-- Metrics -->
                    <div role="tabcard" class="tab-pane" id="metrics">
                        @include('spark::kiosk.metrics')
                    </div>

                    <!-- User Management -->
                    <div role="tabcard" class="tab-pane" id="users">
                        @include('spark::kiosk.users')
                    </div>

                    <!-- API Management -->
                    <div role="tabcard" class="tab-pane" id="api">
                        @include('spark::kiosk.api')
                    </div>

                    <!-- Commission Management -->
                    <div role="tabcard" class="tab-pane" id="commission">
                        @include('spark::kiosk.commission')
                        <div>
                            <div class="card card-default">
                                <div class="card-header">
                                    <div class="row">


                                    <div class="col-md-9 col-sm-6" style="    margin-top: 3px;"> {{__('Commission Sites')}}</div>
                                <div class="col-md-3 col-sm-6 col-xs-6" style="padding-right: 20px;">
                                    <div class="input-group input-group-sm mb-3" style="margin-bottom: 0rem !important;">

                                        <input type="text" class="form-control" id="myInput" onkeyup="myFunction()"  placeholder="Search" aria-describedby="inputGroup-sizing-sm">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
                                        </div>
                                    </div>

                                </div>
                                    </div>
                                </div>
                                {{--TODO Filter Sites--}}
                                <div class="card-body" >
                                    <ul id="myUL" style="list-style: none; padding-left: 0px;">


                                    @forelse(App\Team::all() as $team)
<li><form id="sortForm"  method="POST" action="/commission/update">
        {{ csrf_field() }}
                                        <div class="row">
                                            <div id="team_name" class="col-sm-4" style="display: flex;
    justify-content:center;
    align-content:center;
    flex-direction:column; ">
                                                    <a>{{$team->name}}</a>
                                                <input name="team_id" value="{{$team->id}}" hidden>
                                            </div>

                                            <div class="col-sm-6">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <small class="form-text text-muted col-md-12" style="padding-right: 15px; padding-left: 15px;">{{__('Consultants')}}</small>

                                                            <div class="col-md-12">
                                                                <input class="form-control" type="number" name="comm1_value" @if(App\GlobalCommission::where('team_id', $team->id)->count() != null) value="{{App\GlobalCommission::where('team_id', $team->id)->first()->comm1}}" @endif min="0" max="100">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <small class="form-text text-muted col-md-12" style="padding-right: 15px; padding-left: 15px;">{{__('Marketing')}}</small>

                                                            <div class="col-md-12">
                                                                <input class="form-control" type="number" name="comm2_value" @if(App\GlobalCommission::where('team_id', $team->id)->count() != null) value="{{App\GlobalCommission::where('team_id', $team->id)->first()->comm2}}" @endif min="0" max="100">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <small class="form-text text-muted col-md-12" style="padding-right: 15px; padding-left: 15px;">{{__('IT Support')}}</small>


                                                            <div class="col-md-12">
                                                                <input class="form-control" type="number" name="comm3_value" @if(App\GlobalCommission::where('team_id', $team->id)->count() != null) value="{{App\GlobalCommission::where('team_id', $team->id)->first()->comm3}}" @endif min="0" max="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
<div class="col-md-2" style="display: flex;
    justify-content:center;
    align-content:center;
    flex-direction:column; ">
    <button type="submit" class="btn btn-primary">
        {{__('Ok')}}
    </button>
</div>


                                        </div>
    </form>
                                        <hr>
</li>
                                    @empty
                                    @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Plan Limit Management -->
                    <div role="tabcard" class="tab-pane" id="default-limits">
                        @include('spark::kiosk.limits')
                    </div>
                    <div role="tabcard" class="tab-pane active" id="site-limits">
                        <div class="card card-default mb-12">
                            <div class="card-header">
                                <h2 class="card-title mb-0">{{__('Default Plan Limits')}}
                                    <a class="btn btn-sm btn-primary pull-right" data-toggle="collapse" href="#collapseDefault" role="button" aria-expanded="false" aria-controls="collapseDefault">
                                        +
                                    </a>
                                </h2>
                            </div>
                            <div class="card-body collapse" id="collapseDefault">
                                @forelse(App\SubscriptionTotal::where('plan', $subTotal->plan)->get() as $defaultTotal)
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h4>Plan Name</h4>
                                            <h5>{{$defaultTotal->plan}}</h5>
                                        </div>
                                        <div class="col-lg-8">
                                            <form method="POST" action="/kiosk/sitelimits/update/{{$subTotal->site_subscription_total_id}}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="subscription_total_id" value="{{$defaultTotal->subscription_total_id}}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="col-form-label text-md-right">{{__('Users')}}</label>
                                                        <input class="form-control" disabled type="integer" name="user_total" value="{{$defaultTotal->user_total}}">
                                                        <label class="col-form-label text-md-right">{{__('User Rate')}}</label>
                                                        <input class="form-control" disabled type="integer" step="0.01" name="add_user_price" value="{{$defaultTotal->add_user_price}}">
                                                    </div>
                                                    {{--<div class="col-md-4">--}}
                                                    {{--<label class="col-form-label text-md-right">{{__('Document Total')}}</label>--}}
                                                    {{--<input class="form-control" type="integer" name="doc_total" value="{{$defaultTotal->doc_total}}">--}}
                                                    {{--</div>--}}
                                                    <div class="col-md-4">
                                                        <label class="col-form-label text-md-right">{{__('Wallboards')}}</label>
                                                        <input class="form-control" disabled type="integer" name="wallboard_total" value="{{$defaultTotal->wallboard_total}}">
                                                        <label class="col-form-label text-md-right">{{__('Wallboard Rate')}}</label>
                                                        <input class="form-control" disabled type="integer" step="0.01" name="add_wallboard_price" value="{{$defaultTotal->add_wallboard_price}}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="col-form-label text-md-right">{{__('Document Prints')}}</label>
                                                        <input class="form-control" disabled type="integer" name="doc_exported_total" value="{{$defaultTotal->doc_exported_total}}">
                                                        <label class="col-form-label text-md-right">{{__('Document Rate')}}</label>
                                                        <input class="form-control" disabled type="integer" step="0.01" name="add_doc_price" value="{{$defaultTotal->add_doc_price}}">
                                                    </div>
                                                </div>
                                                {{--<div class="row">--}}
                                                {{--<div class="col-md-4">--}}
                                                {{--<label class="col-form-label text-md-right">{{__('View Total')}}</label>--}}
                                                {{--<input class="form-control" type="integer" name="doc_viewed_total" value="{{$defaultTotal->doc_viewed_total}}">--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-4">--}}
                                                {{--<label class="col-form-label text-md-right">{{__('Edit Total')}}</label>--}}
                                                {{--<input class="form-control" type="integer" name="doc_edited_total" value="{{$defaultTotal->doc_edited_total}}">--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-4">--}}
                                                {{--<label class="col-form-label text-md-right">{{__('Document Print Total')}}</label>--}}
                                                {{--<input class="form-control" type="integer" name="doc_exported_total" value="{{$defaultTotal->doc_exported_total}}">--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{__('Restore Defaults')}}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                    <hr>
                                @empty
                                @endforelse
                            </div>
                        </div>

                        <div class="card card-default mb-12">
                            <div class="card-header">
                                <h2 class="card-title mb-0">{{__('Individual Site Limits')}}
                                    </h2>
                            </div>
                            <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>{{$subTotal->site->team->name}}</h5>
                                <h6>{{$subTotal->plan}}</h6>

                            </div>
                        </div>
                        <form method="POST" action="/kiosk/sitelimits/update/{{$subTotal->site_subscription_total_id}}">
                            {{ csrf_field() }}
                            <div class="row">

                                <div class="col-md-12">

                                    <input type="hidden" name="site_subscription_total_id" value="{{$subTotal->site_subscription_total_id}}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="col-form-label text-md-right">{{__('Users')}}</label>
                                            <input class="form-control" type="integer" name="user_total" value="{{$subTotal->user_total}}">
                                            <label class="col-form-label text-md-right">{{__('User Rate')}}</label>
                                            <input class="form-control" type="integer" step="0.01" name="add_user_price" value="{{$subTotal->add_user_price}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="col-form-label text-md-right">{{__('Wallboards')}}</label>
                                            <input class="form-control" type="integer" name="wallboard_total" value="{{$subTotal->wallboard_total}}">
                                            <label class="col-form-label text-md-right">{{__('Wallboard Rate')}}</label>
                                            <input class="form-control" type="integer" step="0.01" name="add_wallboard_price" value="{{$subTotal->add_wallboard_price}}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="col-form-label text-md-right">{{__('Document Prints')}}</label>
                                            <input class="form-control" type="integer" name="doc_exported_total" value="{{$subTotal->doc_exported_total}}">
                                            <label class="col-form-label text-md-right">{{__('Document Rate')}}</label>
                                            <input class="form-control" type="integer" step="0.01" name="add_doc_price" value="{{$subTotal->add_doc_price}}">
                                            <br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">
                                                {{__('Update')}}
                                            </button>
                                        </div>

                                    </div>


                                </div>

                            </div>
                        </form>
                        <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>{{__('Additional Billing')}}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    @forelse(App\ExtraSiteBilling::where('site_id', $subTotal->site_id)->get() as $extraBillingItem)
                                    <div class="col-md-4">
                                        <div class="card card-default mb-12">
                                            <div class="card-header">
                                                <h2 class="card-title mb-0">{{$extraBillingItem->ModuleBilling->name}}

                                                </h2>
                                            </div>
                                            <div class="card-body">
                                                <form method="POST" action="/kiosk/module-extras/update/{{$extraBillingItem->site_extra_id}}">
                                                    {{ csrf_field() }}
                                                    <input name="site_id" value="{{$subTotal->site_id}}" type="hidden">

                                                    <label class="col-form-label text-md-right">{{__('Item')}}</label>
                                                    <input class="form-control" type="text" name="custom_name" value="{{$extraBillingItem->custom_name}}">
                                                    <label class="col-form-label text-md-right">{{__('Description')}}</label>
                                                    <input class="form-control" type="text" name="custom_description" value="{{$extraBillingItem->custom_description}}">
                                                <label class="col-form-label text-md-right">{{__('Units')}}</label>
                                                <input class="form-control" type="integer" name="total" value="{{$extraBillingItem->total}}">
                                                <label class="col-form-label text-md-right">{{__('Rate')}}</label>
                                                <input class="form-control" type="integer" step="0.01" name="price" value="{{$extraBillingItem->price}}">
                                                <br>
                                                    <div>
                                                        <button type="submit" class="btn btn-primary">
                                                            {{__('Update')}}
                                                        </button>
                                                        <a href="/kiosk/module-extras/remove/{{$extraBillingItem->site_extra_id}}" onclick="return confirm('Are you sure?')" class="btn btn-danger pull-right">
                                                            {{__('Remove')}}
                                                        </a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse
                                        <div class="col-md-4">
                                            <div class="card card-default mb-12">
                                                <div class="card-header">
                                                    <h2 class="card-title mb-0">{{__('Add New Item')}}
                                                    </h2>
                                                </div>
                                                <div class="card-body">
                                                    <form method="POST" action="/kiosk/module-extras/add/{{$subTotal->site_id}}">
                                                        {{ csrf_field() }}
                                                        <input name="site_id" value="{{$subTotal->site_id}}" type="hidden">
                                                        <label class="col-form-label text-md-right">{{__('Category')}}</label>
                                                        <select class="form-control" name="module_billing_id">
                                                            @forelse(App\ExtraModuleBilling::all() as $moduleBilling)
                                                            <option value="{{$moduleBilling->module_billing_id}}">{{$moduleBilling->name}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        <label class="col-form-label text-md-right">{{__('Item')}}</label>
                                                        <input class="form-control" type="text" name="custom_name" value="">
                                                        <label class="col-form-label text-md-right">{{__('Description')}}</label>
                                                        <input class="form-control" type="text" name="custom_description" value="">
                                                        <label class="col-form-label text-md-right">{{__('Units')}}</label>
                                                        <input class="form-control" type="integer" name="total" value="">
                                                        <label class="col-form-label text-md-right">{{__('Rate')}}</label>
                                                        <input class="form-control" type="integer" step="0.01" name="price" value="">
                                                                <br>
                                                        <button type="submit" class="btn btn-primary">
                                                            {{__('Add')}}
                                                        </button>
                                                    </form>
                                        </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function myFunction() {
            // Declare variables
            var input, filter, ul, li, a, i;
            input = document.getElementById('myInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName('li');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
</spark-kiosk>
@endsection
