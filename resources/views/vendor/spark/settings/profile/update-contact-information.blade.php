<spark-update-contact-information :user="user" inline-template>
    <div class="card card-default">
        <div class="card-header">{{__('Contact Information')}}</div>

        <div class="card-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                {{__('Your contact information has been updated!')}}
            </div>

            <form role="form">
                <!-- Name -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Name')}}</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" v-model="form.name" :class="{'is-invalid': form.errors.has('name')}">

                        <span class="invalid-feedback" v-show="form.errors.has('name')">
                            @{{ form.errors.get('name') }}
                        </span>
                    </div>
                </div>

                <!-- E-Mail Address -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('E-Mail Address')}}</label>

                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" v-model="form.email" :class="{'is-invalid': form.errors.has('email')}">

                        <span class="invalid-feedback" v-show="form.errors.has('email')">
                            @{{ form.errors.get('email') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update"
                                :disabled="form.busy">

                            {{__('Update')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-contact-information>

<div class="card card-default">
    <div class="card-header">{{__('Payment Information')}}</div>

    <div class="card-body">
        <!-- Success Message -->


        <form>

{{--TODO Create Payment Table and store this info to that table--}}
            <!-- E-Mail Address -->
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">{{__('PayPal Address')}}</label>

                <div class="col-md-6">
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">@ <i class="fa fa-paypal"></i> </div>
                        </div>
                        <input type="text" class="form-control py-0" id="inlineFormInputGroupUsername2" placeholder="Username">
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

<spark-update-password inline-template>
    <div class="card card-default">
        <div class="card-header">{{__('Update Password')}}</div>

        <div class="card-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                {{__('Your password has been updated!')}}
            </div>

            <form role="form">
                <!-- Current Password -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Current Password')}}</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="current_password" v-model="form.current_password" :class="{'is-invalid': form.errors.has('current_password')}">

                        <span class="invalid-feedback" v-show="form.errors.has('current_password')">
                            @{{ form.errors.get('current_password') }}
                        </span>
                    </div>
                </div>

                <!-- New Password -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Password')}}</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password" v-model="form.password" :class="{'is-invalid': form.errors.has('password')}">

                        <span class="invalid-feedback" v-show="form.errors.has('password')">
                            @{{ form.errors.get('password') }}
                        </span>
                    </div>
                </div>

                <!-- New Password Confirmation -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Confirm Password')}}</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password_confirmation" v-model="form.password_confirmation" :class="{'is-invalid': form.errors.has('password_confirmation')}">

                        <span class="invalid-feedback" v-show="form.errors.has('password_confirmation')">
                            @{{ form.errors.get('password_confirmation') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update"
                                :disabled="form.busy">

                            {{__('Update')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-password>