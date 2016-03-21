var Vue = require('vue-install');

module.exports = {

    el: '.widget_subscriptionwidget',

    data: {
        url:        ajaxurl + '?action=wpps_v1_',
        success:    false,
        subscriber: {
            email: ''
        }
    },

    methods: {

        subscribe: function () {
            this.$http.post(this.url + 'subscribe_post', this.subscriber).then(function (response) {
                this.$set('success', true);
                this.$set('subscriber.email', "");
            });
        }

    }

}
;

Vue.ready(module.exports);
