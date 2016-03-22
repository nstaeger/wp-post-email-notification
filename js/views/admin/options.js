var Vue = require('vue-install');

module.exports = {

    el: '#wp-ps-options',

    data: {
        url:           ajaxurl + '?action=wpps_v1_',
        jobs:          [],
        subscribers:   [],
        newSubscriber: {
            email: ""
        }
    },

    ready: function () {
        this.$http.post(this.url + 'subscriber_get').then(function (response) {
            this.$set('subscribers', response.data);
        });

        this.$http.post(this.url + 'job_get').then(function (response) {
            this.$set('jobs', response.data);
        });
    },

    methods: {

        addNewSubscriber: function () {
            this.$http.post(this.url + 'subscriber_post', this.newSubscriber).then(function (response) {
                this.$set('subscribers', response.data);
                this.$set('newSubscriber.email', "");
            });
        },

        deleteJob: function (id) {
            if (!window.confirm("Do you really want to delete job #" + id + "?")) {
                return;
            }

            var data = {
                id: id
            };

            this.$http.post(this.url + 'job_delete', data).then(function (response) {
                this.$set('jobs', response.data);
            });
        },

        deleteSubscriber: function (id) {
            if (!window.confirm("Do you really want to delete subscriber #" + id + "?")) {
                return;
            }

            var data = {
                id: id
            };

            this.$http.post(this.url + 'subscriber_delete', data).then(function (response) {
                this.$set('subscribers', response.data);
            });
        }
    }

};

Vue.ready(module.exports);
