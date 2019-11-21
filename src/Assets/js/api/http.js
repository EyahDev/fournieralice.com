var axios = require('axios');
var join = require('url-join');

// https://github.com/sindresorhus/is-absolute-url/blob/master/index.js#L7
var isAbsoluteURLRegex = /^(?:\w+:)\/\//;

axios.interceptors.request.use(function(config) {
    // Concatenate base path if not an absolute URL
    // if ( !isAbsoluteURLRegex.test(config.url) ) {
    //     config.url = join('/~kif-kebab/public', config.url);
    // }

    return config;
});

export default axios