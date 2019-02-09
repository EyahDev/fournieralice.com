var encore = require('@symfony/webpack-encore');

encore
    .configureFilenames({
        js: 'js/[name].js',
        css: 'css/[name].css',
        images: 'img/[name].css',
        fonts: 'fonts/[name].css'
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
