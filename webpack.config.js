var webpack = require("webpack");

module.exports = [

    {
        entry:   {
            "admin-options":   "./js/views/admin/options",
            "frontend-widget": "./js/views/frontend/widget"
        },
        output:  {
            filename: "./js/bundle/[name].js"
        },
        resolve: {
            alias: {
                "vue-install": __dirname + "/js/vue-install.js"
            }
        },
        plugins: [
            new webpack.optimize.UglifyJsPlugin({minimize: true})
        ]
    }

];
