var base = require('settings/teams/pending-invitations');

Vue.component('spark-pending-invitations', {
    mixins: [base],
    methods: {
        /**
         * Accept the given invitation.
         */
        accept(invitation) {
            axios.post(`/settings/invitations/${invitation.id}/accept`)
                .then(() => {
                    Bus.$emit('updateTeams');

                    this.getPendingInvitations();
                });

            this.removeInvitation(invitation);

            window.location.href = `/settings/teams/${invitation.team_id}/switch`;
            window.location.href = '/sites';
        },
    }
});

