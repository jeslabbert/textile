<update-profile-details :user="user" inline-template>
    <div class="card card-default">
        <div class="card-header">{{__('Contact Information')}}</div>

        <div class="card-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                Your profile has been updated!
            </div>

            <form role="form">
                <!-- Age -->
                <!-- Username -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Username')}}</label>

                    <div class="col-md-6">
                        <input type="text" disabled class="form-control" name="username" v-model="form.username" :class="{'is-invalid': form.errors.has('username')}">

                        <span class="invalid-feedback" v-show="form.errors.has('username')">
                            @{{ form.errors.get('username') }}
                        </span>
                    </div>
                </div>
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
                <!-- Last Name -->
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">{{__('Last Name')}}</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" name="last_name" v-model="form.last_name" :class="{'is-invalid': form.errors.has('last_name')}">

                        <span class="invalid-feedback" v-show="form.errors.has('last_name')">
                            @{{ form.errors.get('last_name') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update"
                                :disabled="form.busy">

                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</update-profile-details>