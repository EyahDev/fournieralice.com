/* Imports le JS d'UIKit  */
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

UIkit.use(Icons);

/* Imports CSS */
import '../css/app.scss'

/* Import vue */
import Vue from 'vue';

/* Import des composants vue */
import login from  '../components/login.vue';

/* Chargement des composants vue */
Vue.component('login', login);

/* Rendu vue */
new Vue({
    el: '#app',
});