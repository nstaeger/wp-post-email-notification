module.exports = [

    {
        entry:  {
            "admin-options": "./js/views/admin/options"
        },
        output: {
            filename: "./js/bundle/[name].js"
        },
        resolve: {
            alias: {
                "vue-install": __dirname + "/js/vue-install.js"
            }
        }
    }

];
