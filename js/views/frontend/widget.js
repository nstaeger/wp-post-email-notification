var Vue = require('vue-install');

module.exports = {

    el: '.widget_subscriptionwidget',

    data: {
        url:                  ajaxurl + '?action=wppen_v1_',
        currentlySubscribing: false,
        success:              false,
        subscriber:           {
            email: ''
        }
    },

    methods: {

        subscribe: function () {
            if (!this.currentlySubscribing) {
                this.$set('currentlySubscribing', true);
                this.$http.post(this.url + 'subscribe_post', this.subscriber).then(function (response) {
                    this.$set('currentlySubscribing', true);
                    this.$set('success', true);
                    this.$set('subscriber.email', "");
                });
            }
        }

    }

}
;

Vue.ready(module.exports);
