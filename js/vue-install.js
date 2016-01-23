var Vue = require('vue');

function install (Vue) {

    Vue.use(require('vue-resource'));

    Vue.ready = function (fn) {

        if (Vue.util.isObject(fn)) {

            var options = fn;

            fn = function () {
                new Vue(options);
            };

        }

        var handle = function () {
            document.removeEventListener('DOMContentLoaded', handle);
            window.removeEventListener('load', handle);
            fn();
        };

        if (document.readyState === 'complete') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', handle);
            window.addEventListener('load', handle);
        }

    };
}

Vue.use(install);

module.exports = Vue;
