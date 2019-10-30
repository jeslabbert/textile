var base = require('settings/teams/create-team');

Vue.component('spark-create-team', {
    mixins: [base],
    methods: {
        create() {
            Spark.post('/settings/'+Spark.teamsPrefix, this.form)
                .then(() => {
                    this.form.name = '';
                    this.form.slug = '';
                    Bus.$emit('updateUser');
                    Bus.$emit('updateTeams');
                    window.open('/teamswitchlatest', '_self');
                });
        },
        visitSite(team) {

            axios.get(`/get_team/${team.id}`)
                .then(response => {

                    this.visitTeam = response.data;
                    window.open('http://' + this.visitTeam, '_blank');
                })
                .catch(response => {
                    //
                });

        },

    },
});
