var Vue = require('vue-install');

module.exports = {

    el: '.widget_subscriptionwidget',

    data: {
        url:        ajaxurl + "?action=ps_ajax",
        success:    false,
        subscriber: {
            email: ''
        }
    },

    methods: {

        subscribe: function () {
            var data = {
                action: 'subscribe',
                data:   this.subscriber
            };

            this.$http.post(this.url, data).then(function (response) {
                this.$set('success', true);
                this.$set('subscriber.email', "");
            });
        }

    }

}
;

Vue.ready(module.exports);
