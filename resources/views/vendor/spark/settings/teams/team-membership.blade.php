<spark-team-membership :user="user" :team="team" :billable-type="billableType" inline-template>
    <div>
        @if (Auth::user()->ownsTeam($team))
            <!-- Send Invitation -->
            <div v-if="user && team">
                @include('spark::settings.teams.send-invitation')
            </div>

            <!-- Pending Invitations -->
            <div v-if="invitations && invitations.length > 0">
                @include('spark::settings.teams.mailed-invitations')
            </div>
        @endif

        <!-- Team Members -->
        <div v-if="user && team">
            @include('spark::settings.teams.team-members')
        </div>
            <!-- Team Members -->
            @if (Spark::developer(Auth::user()->email))
                @include('spark::settings.teams.team-owner')
                @else
            <div v-if="user.id === team.owner_id">
                @include('spark::settings.teams.team-owner')
            </div>
                @endif
    </div>
</spark-team-membership>
