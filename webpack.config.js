var webpack = require('webpack');
var path = require('path');

var VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
    entry: './src/Assets/js/app.js',
    output: {
        path: path.resolve(__dirname, 'public/build/js'),
        filename: 'app.js'
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [
                    'style-loader',
                    'css-loader'
                ]
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            }
        ]
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            jquery: "jquery",
        }),
        new VueLoaderPlugin()
    ]
};