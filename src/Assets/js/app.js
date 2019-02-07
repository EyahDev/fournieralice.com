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