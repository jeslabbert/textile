var base = require('settings/teams/current-teams');

Vue.component('spark-current-teams', {
    mixins: [base],
    methods: {
        visitSite(team) {

            axios.get(`/get_team/${team.id}`)
                .then(response => {

                    this.visitTeam = response.data;
                    window.open('http://' + this.visitTeam, '_blank');
                })
                .catch(response => {
                    //
                });

        }
    },

});


