var Vue = require('vue-install');

module.exports = {

    el: '#wp-ps-options',

    data: {
        url:           ajaxurl + "?action=ps_ajax",
        subscribers:   null,
        newSubscriber: {
            email: ""
        }
    },

    ready: function () {
        var data = {
            action: 'get_subscribers'
        };

        this.$http.post(this.url, data).then(function (response) {
            this.$set('subscribers', response.data);
        });
    },

    methods: {

        addNewSubscriber: function () {
            var data = {
                action: 'add_subscriber',
                data:   this.newSubscriber
            };

            this.$http.post(this.url, data).then(function (response) {
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
