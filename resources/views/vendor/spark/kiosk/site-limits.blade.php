<div class="card card-default mb-12">
    <div class="card-header">
        <h2 class="card-title mb-0">{{__('Default Plan Limits')}}</h2>
    </div>
    <div class="card-body">
        @forelse(App\SubscriptionTotal::all() as $subTotal)
            <div class="row">
                <div class="col-lg-4">
                    <h4>Plan Name</h4>
                    <h5>{{$subTotal->plan}}</h5>
                </div>
                <div class="col-lg-8">
                    <form method="POST" action="/kiosk/limits/update/{{$subTotal->subscription_total_id}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="subscription_total_id" value="{{$subTotal->subscription_total_id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="col-form-label text-md-right">{{__('Users')}}</label>
                                <input class="form-control" type="integer" name="user_total" value="{{$subTotal->user_total}}">
                                <label class="col-form-label text-md-right">{{__('User Rate')}}</label>
                                <input class="form-control" type="integer" step="0.01" name="add_user_price" value="{{$subTotal->add_user_price}}">
                            </div>
                            {{--<div class="col-md-4">--}}
                            {{--<label class="col-form-label text-md-right">{{__('Document Total')}}</label>--}}
                            {{--<input class="form-control" type="integer" name="doc_total" value="{{$subTotal->doc_total}}">--}}
                            {{--</div>--}}
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
                            </div>
                        </div>
                        {{--<div class="row">--}}
                        {{--<div class="col-md-4">--}}
                        {{--<label class="col-form-label text-md-right">{{__('View Total')}}</label>--}}
                        {{--<input class="form-control" type="integer" name="doc_viewed_total" value="{{$subTotal->doc_viewed_total}}">--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<label class="col-form-label text-md-right">{{__('Edit Total')}}</label>--}}
                        {{--<input class="form-control" type="integer" name="doc_edited_total" value="{{$subTotal->doc_edited_total}}">--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<label class="col-form-label text-md-right">{{__('Document Print Total')}}</label>--}}
                        {{--<input class="form-control" type="integer" name="doc_exported_total" value="{{$subTotal->doc_exported_total}}">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{__('Update')}}
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
        <h2 class="card-title mb-0">{{__('Individual Site Limits')}}</h2>
    </div>
    <div class="card-body">
        @forelse(App\SiteSubscriptionTotal::all() as $subTotal)
            @if(isset($subTotal->site->team->name))

            <div class="row">
                <div class="col-md-5">
                    <h5>{{$subTotal->site->team->name}}</h5>


                </div>
                <div class="col-md-5">

                    <p>{{$subTotal->plan}}</p>
                </div>
                <div class="col-md-2 text-center">
                    <a href="/kiosk/sitelimits/show/{{$subTotal->site_subscription_total_id}}" class="btn btn-sm btn-primary">
                        {{__('View')}}
                    </a>

                </div>

            </div>
            <hr>
            @endif
        @empty
        @endforelse

        <div class="row">
            <div class="col-md-4">
                <label class="col-form-label text-md-right">{{__('Name')}}</label>
                <input class="form-control" type="text" name="wallboard_total" value="">
                <label class="col-form-label text-md-right">{{__('Custom Rate')}}</label>
                <input class="form-control" type="integer" step="0.01" name="add_wallboard_price" value="">
            </div>
            <div class="col-md-4">
                <label class="col-form-label text-md-right">{{__('Name')}}</label>
                <input class="form-control" type="text" name="wallboard_total" value="">
                <label class="col-form-label text-md-right">{{__('Custom Rate')}}</label>
                <input class="form-control" type="integer" step="0.01" name="add_wallboard_price" value="">
            </div>
            <div class="col-md-4">
                <label class="col-form-label text-md-right">{{__('Name')}}</label>
                <input class="form-control" type="text" name="wallboard_total" value="">
                <label class="col-form-label text-md-right">{{__('Custom Rate')}}</label>
                <input class="form-control" type="integer" step="0.01" name="add_wallboard_price" value="">
            </div>
        </div>
    </div>
</div>