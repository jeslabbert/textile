<spark-profile :user="user" inline-template>
    <div>
        <!-- Update Profile Photo -->
        @include('spark::settings.profile.update-profile-photo')
        <!-- Update Contact Information -->
        @include('settings.profile.update-profile-details')

        @include('spark::settings.profile.update-contact-information')

    </div>
</spark-profile>
