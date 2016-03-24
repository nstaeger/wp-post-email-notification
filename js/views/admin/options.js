var Vue = require('vue-install');

module.exports = {

    el: '#wp-ps-options',

    data: {
        url:                 ajaxurl + '?action=wppen_v1_',
        options:             [],
        jobs:                [],
        subscribers:         [],
        newSubscriber:       {
            email: ""
        },
        updatingOptions:     false,
        updatingSubscribers: false
    },

    ready: function () {
        this.$http.get(this.url + 'option_get').then(function (response) {
            this.$set('options', response.data);
        }, this.handleError);

        this.$http.get(this.url + 'subscriber_get').then(function (response) {
            this.$set('subscribers', response.data);
        }, this.handleError);

        this.$http.get(this.url + 'job_get').then(function (response) {
            this.$set('jobs', response.data);
        }, this.handleError);
    },

    methods: {

        addNewSubscriber: function () {
            this.$set('updatingSubscribers', true);
            this.$http.post(this.url + 'subscriber_post', this.newSubscriber).then(function (response) {
                this.$set('subscribers', response.data);
                this.$set('newSubscriber.email', "");
                this.$set('updatingSubscribers', false);
            }, function(response) {
                this.$set('updatingSubscribers', false);
                this.handleError(response);
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
            }, this.handleError);
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
            }, this.handleError);
        },

        handleError: function(response) {
            alert("Could not complete action: " + response.data);
        },

        updateOptions: function () {
            this.$set('updatingOptions', true);
            this.$http.post(this.url + 'option_put', this.options).then(function () {
                this.$set('updatingOptions', false);
            }, function(response) {
                this.$set('updatingOptions', false);
                this.handleError(response);
            });
        }
    }

};

Vue.ready(module.exports);
