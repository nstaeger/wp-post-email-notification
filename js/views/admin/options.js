var Vue = require('vue-install');

module.exports = {

    el: '#wp-ps-options',

    data: {
        url:           ajaxurl + '?action=wpps_v1_',
        subscribers:   null,
        newSubscriber: {
            email: ""
        }
    },

    ready: function () {
        this.$http.post(this.url + 'subscriber_get').then(function (response) {
            this.$set('subscribers', response.data);
        });
    },

    methods: {

        addNewSubscriber: function () {
            this.$http.post(this.url + 'subscriber_post', this.newSubscriber).then(function (response) {
                this.$set('subscribers', response.data);
                this.$set('newSubscriber.email', "");
            });
        },

        deleteSubscriber: function (id) {
            if (!window.confirm("Do you really want to delete subscriber #" + id + "?")) {
                return;
            }

            var data = {
                action: 'delete_subscriber',
                data:   {
                    id: id
                }
            };

            this.$http.post(this.url, data).then(function (response) {
                this.$set('subscribers', response.data);
            });
        }
    }

};

Vue.ready(module.exports);
