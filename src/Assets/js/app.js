/* Imports le JS d'UIKit  */
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

UIkit.use(Icons);

/* Imports CSS */
import '../css/app.scss'

/* Import vue */
import Vue from 'vue';
import axios from './api/http.js';
import Routage from './api/routing.js';

window.$http = axios;
window.Routing = Routage;

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

/* Import de moment */
import Moment from 'moment';
import localization from 'moment/locale/fr';

moment.updateLocale('fr', localization);

Vue.filter('standardDate', function(value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY hh:mm:ss')
  }
});


/* Import des composants vue */
import Editor from '@tinymce/tinymce-vue'
import login from  '../components/login.vue';
import About from '../components/About.vue';
import AboutEditor from '../components/Admin/AboutEdit.vue';
import News from '../components/News.vue';
import NewsList from '../components/Admin/NewsList.vue';
import NewsEdit from '../components/Admin/NewsEdit.vue';

/* Chargement des composants vue */
Vue.component('editor', Editor);
Vue.component('login', login);
Vue.component('about-section', About);
Vue.component('about-edit', AboutEditor);
Vue.component('news', News);
Vue.component('news-list', NewsList);
Vue.component('news-edit', NewsEdit);

/* Rendu vue */
new Vue({
    el: '#app',
});
