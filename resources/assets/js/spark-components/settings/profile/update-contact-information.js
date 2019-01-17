var base = require('settings/profile/update-contact-information');

Vue.component('spark-update-contact-information', {
    mixins: [base],

    data() {
        return {
            form: $.extend(true, new SparkForm({
                name: '',
                last_name: '',
                email: ''
            }), Spark.forms.updateContactInformation)
        };
    },


    /**
     * Bootstrap the component.
     */
    mounted() {
        this.form.username = this.user.username;
        this.form.name = this.user.name;
        this.form.last_name = this.user.last_name;
        this.form.email = this.user.email;
    },

    methods: {
        /**
         * Update the user's contact information.
         */
        update() {
            Spark.put('/settings/contact', this.form)
                .then(() => {
                    Bus.$emit('updateUser');
                });
        }
    }
});
