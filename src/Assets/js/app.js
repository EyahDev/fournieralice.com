/* Import vue */
import Vue from 'vue';
/* Importation des traductions */
import Lang from 'lang.js';
import translations from './translations';
var lang = new Lang({
    locale: 'fr',
});
lang.setLocale('fr');
lang.setMessages(translations);

Vue.filter('trans', (...args) => {
    return lang.get(...args);
});

Vue.mixin({
    data: function() {
        return {
            get translation() {
                return lang;
            }
        }
    }
});



/* Import des composants vue */
import login from  '../components/login.vue';

/* Chargement des composants vue */
Vue.component('login', login);

/* Rendu vue */
new Vue({
    el: '#app',
});
