/* Imports le JS d'UIKit  */
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

UIkit.use(Icons);

/* Imports CSS */
import '../css/app.scss'

/* Imports de ParticlesJS */
import 'particles.js'

particlesJS.load('particles-js', '../particles.json', function() {});

/* Import vue */
import Vue from 'vue';

let VueCookie = require('vue-cookie');
Vue.use(VueCookie);

/* Importation des traductions */
import Lang from 'lang.js';
import translations from './translations';

let lang = new Lang({
    locale: 'fr',
});

lang.setLocale(getLocale());
lang.setMessages(translations);

Vue.filter('trans', (...args) => {
    return lang.get(...args);
});

Vue.mixin({
    data: function () {
        return {
            get translation() {
                return lang;
            }
        }
    },
    methods: {
        changeLang(){
            if(lang.getLocale() === 'fr'){
                lang.setLocale('en');
                Vue.cookie.set('lang', 'en', 7);
            }else{
                lang.setLocale('fr');
                Vue.cookie.set('lang', 'fr', 7);
            }
        }
    }
});

function getLocale() {
    if (Vue.cookie.get('lang')) {
        return Vue.cookie.get('lang');
    }
    let navLoc = navigator.language;
    if (navLoc !== undefined) {
        let locale = (navLoc.substr(0, 2) !== 'en') ? 'fr' : navLoc.substr(0, 2);
        Vue.cookie.set('lang', locale, 7);
        return locale;
    }
    return 'fr'
}

/* Import des composants vue */
import login from  '../components/login.vue';
import forgottenPassword from  '../components/security/forgotten-password.vue';

/* Chargement des composants vue */
Vue.component('login', login);
Vue.component('forgotten-password', forgottenPassword);

/* Rendu vue */
new Vue({
    el: '#app',
});
