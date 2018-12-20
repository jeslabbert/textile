<spark-api inline-template>


        <!-- Commission -->
        <div>
            <div class="card card-default">
                <div class="card-header">{{__('Commission Defaults')}}</div>
                <div class="card-body">
                    <form style="margin:auto;" method="POST" action="/commission/defaults">
                    {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group row">
                                    <small class="form-text text-muted col-md-12" style="padding-right: 15px; padding-left: 15px;">{{__('Default PayPal Account')}}</small>

                                    <div class="col-md-12">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">@ <i class="fa fa-paypal"></i> </div>
                                            </div>
                                            <input value="{{App\Setting::where('setting_type', 'Commission')->where('setting_name', 'PayPal')->first()->setting_string}}" name="paypal_value" type="text" class="form-control py-0" id="inlineFormInputGroupUsername2" placeholder="Username">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <small class="form-text text-muted col-md-12" style="padding-right: 15px; padding-left: 15px;">{{__('Consultants')}}</small>

                                    <div class="col-md-12">
                                        <input class="form-control" type="number" name="consultant_value" value="{{App\Setting::where('setting_type', 'Commission')->where('setting_name', 'Consultant')->first()->setting_value}}" min="0" max="100">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <small class="form-text text-muted col-md-12" style="padding-right: 15px; padding-left: 15px;">{{__('Marketing')}}</small>

                                    <div class="col-md-12">
                                        <input class="form-control" type="number" name="marketing_value" value="{{App\Setting::where('setting_type', 'Commission')->where('setting_name', 'Marketing')->first()->setting_value}}" min="0" max="100">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <small class="form-text text-muted col-md-12" style="padding-right: 15px; padding-left: 15px;">{{__('IT Support')}}</small>


                                    <div class="col-md-12">
                                        <input class="form-control" type="number" name="technical_value" value="{{App\Setting::where('setting_type', 'Commission')->where('setting_name', 'IT Support')->first()->setting_value}}" min="0" max="100">
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
                </div>
            </div>
        </div>


</spark-api>
