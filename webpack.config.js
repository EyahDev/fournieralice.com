var encore = require('@symfony/webpack-encore');

encore
    .configureFilenames({
        js: 'js/[name].js',
        css: 'css/[name].css',
        images: 'img/[name].[ext]',
        fonts: 'fonts/[name].[ext]'
    })

    .setOutputPath('public/build')
    .setPublicPath('/build')

    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        jquery: 'jquery',
        'window.jQuery': 'jquery',
    })

    .addEntry('app', './src/Assets/js/app.js')
    .enableVueLoader()
    .addLoader({
        test: /\.scss$/,
        use: [
            "style-loader", // creates style nodes from JS strings
            "css-loader", // translates CSS into CommonJS
            "sass-loader" // compiles Sass to CSS, using Node Sass by default
        ]
    })

    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild();

module.exports = encore.getWebpackConfig();

//Configuration Webpack, au cas ou...

// module.exports = {
//     entry: './src/Assets/js/app.js',
//     output: {
//         path: path.resolve(__dirname, 'public/build/js'),
//         filename: 'app.js'
//     },
//     module: {
//         rules: [
//             {
//                 test: /\.css$/,
//                 use: [
//                     'style-loader',
//                     'css-loader'
//                 ]
//             },
//             {
//                 test: /\.vue$/,
//                 loader: 'vue-loader'
//             }
//         ]
//     },
//     plugins: [
//         new webpack.ProvidePlugin({
//             $: "jquery",
//             jQuery: "jquery",
//             jquery: "jquery",
//         }),
//         new VueLoaderPlugin()
//     ]
// };
