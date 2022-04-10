/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import router from './assets/router.js';
import Vuelidate from 'vuelidate';
import Vue from 'vue';
import VueAWN from "vue-awesome-notifications";
import store from './store/store'
import cart from './store/cart'
import VuejsDialog from 'vuejs-dialog';
import 'vuejs-dialog/dist/vuejs-dialog.min.css';
import Vuex from "vuex";
import mixins from './plugins/mixin'
import VueSimpleAlert from "vue-simple-alert";
 





//import helpers from './components/config/helpers.js';
// window.Vue = Vue;
// window.Vuemit = require('vuemit');


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Vue.component('header-component', require('./components/HeaderComponent.vue').default);

Vue.use(Vuelidate);
Vue.use(VueAWN);
Vue.use(VuejsDialog);
Vue.use(BootstrapVue);
Vue.use(Vuex);
Vue.use(VueSimpleAlert, { reverseButtons: true });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    render: h => h(App),
            store,
            cart,
            router
        }).$mount('#app')
   




