let encore = require('@symfony/webpack-encore');

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
        moment: 'moment'
    })

    .addEntry('app', './src/Assets/js/app.js')
    .enableVueLoader()

    .addLoader({
        test: /\.s[ac]ss$/i,
        use: [
            "style-loader",
            "css-loader",
            "sass-loader"
        ]
    })

    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild();

module.exports = encore.getWebpackConfig();
