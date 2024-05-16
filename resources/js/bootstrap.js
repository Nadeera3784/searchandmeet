window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.$ = window.jQuery = require('jquery');

window.axios = require('axios');

window.qrCode = require('qrcode');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.post['Content-Type'] = 'application/json';
window.axios.defaults.headers.post['Accept'] = 'application/json';
//window.axios.defaults.baseURL = 'http://localhost/api/v1';
window.axios.defaults.baseURL = 'https://searchmeetings.com/api/v1';
