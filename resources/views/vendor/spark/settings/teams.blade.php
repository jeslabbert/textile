<spark-teams :user="user" :teams="teams" inline-template>
    <div>
        <!-- Pending Invitations -->
    @include('spark::settings.teams.pending-invitations')

        <!-- Create Team -->
        @if (Spark::createsAdditionalTeams())
            @include('spark::settings.teams.create-team')
        @endif



        <!-- Current Teams -->
        <div v-if="user && teams.length > 0">
            @include('spark::settings.teams.current-teams')
        </div>
    </div>
</spark-teams>
