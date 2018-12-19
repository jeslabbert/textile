<spark-api inline-template>


        <!-- Commission -->
        <div>
            <div class="card card-default">
                <div class="card-header">{{__('Commission Defaults')}}</div>
                <div class="card-body">
                    <form style="margin:auto;" method="POST" action="/commission/defaults">
                    {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-left">{{__('Default PayPal Account')}}</label>

                                    <div class="col-md-8">
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">@ <i class="fa fa-paypal"></i> </div>
                                            </div>
                                            <input type="text" class="form-control py-0" id="inlineFormInputGroupUsername2" placeholder="Username">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-6 col-form-label text-md-right">{{__('Consultants')}}</label>

                                    <div class="col-md-4">
                                        <select name="second_user_id" class="browser-default custom-select">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-6 col-form-label text-md-right">{{__('Marketing')}}</label>

                                    <div class="col-md-4">
                                        <select name="second_user_id" class="browser-default custom-select">
                                            <option value="1">10</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-6 col-form-label text-md-right">{{__('IT Support')}}</label>

                                    <div class="col-md-4">
                                        <select name="second_user_id" class="browser-default custom-select">
                                            <option value="1">100</option>
                                            <option value="2">200</option>
                                            <option value="3">300</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                {{__('Update')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


</spark-api>
