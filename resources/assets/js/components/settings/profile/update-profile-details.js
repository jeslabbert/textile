Vue.component('update-profile-details', {
    props: ['user'],

    data() {
        return {
            form: new SparkForm({
                username: '',
                name: '',
                last_name: ''
            })
        };
    },

    mounted() {
        this.form.username = this.user.username;
        this.form.name = this.user.name;
        this.form.last_name = this.user.last_name;
    },

    methods: {
        update() {
            Spark.put('/settings/profile/details', this.form)
                .then(response => {
                    Bus.$emit('updateUser');
                });
        }
    }
});