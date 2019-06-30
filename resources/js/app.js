/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

//add fon awesome library and component
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
library.add(fas);
Vue.component('font-awesome-icon', FontAwesomeIcon);

// init locales
import { Locales } from './Locales.js';
var loc = new Locales({
    route   : appConfig.locales.route,
    module  : [ 'messages', 'auth', 'default', 'user', 'pagination' ],
    locale  : appConfig.locales.code
});
//define translation filter
Vue.filter('translate', function () {
    return loc.translate(arguments);
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './App.vue';
const app = new Vue({
    el: '#app',
    data : {
        loc     : loc,
        routes  : appConfig.routes
    },
    render: h => h(App)

});
