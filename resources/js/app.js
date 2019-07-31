/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.eventBus = new Vue()
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import VueRouter from 'vue-router'
import StoreData from './store/store'
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css';
// import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader
import 'material-design-icons-iconfont/dist/material-design-icons.css'
// // import Buefy from 'buefy'
// import 'buefy/dist/buefy.css'




import Vuex from 'vuex';
import FileManager from 'laravel-file-manager'

Vue.use(Vuex);

// create Vuex store, if you don't have it
// const store = new Vuex.Store();
const store = new Vuex.Store(StoreData)

Vue.use(FileManager, {store});


import VueGoodTablePlugin from 'vue-good-table';

// import the styles
import 'vue-good-table/dist/vue-good-table.css'

Vue.use(VueGoodTablePlugin);

// import VueCharts from 'vue-chartjs'
// import { Bar, Line } from 'vue-chartjs'
// import BootstrapVue from 'bootstrap-vue'
// import VueBarcode from '@chenfengyuan/vue-barcode';

// import Chartkick from 'vue-chartkick'
// import Chart from 'chart.js'
// Vue.use(Chartkick.use(Chart))

// Vue.component(VueBarcode.name, VueBarcode);
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'


// Vue.use(BootstrapVue)
Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(Vuex)
Vue.use(ElementUI, { locale });
// Vue.use(Buefy)

// const store = new Vuex.Store(StoreData)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import myHeader from './components/include/HeadView'
import myDashboard from './components/Dashboard';
import myUser from './components/users/User';
import myRoles from './components/users/roles/Roles';
import myClient from './components/client/Client.vue';
import myFirm from './components/firm/Firm';

import myCase from './components/cases/Cases';
import myFiles from './components/Test';
import myCalendar from './components/calendar/Calendar';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const routes = [
    { path: '/', component: myDashboard },
    { path: '/users', component: myUser },
    { path: '/roles', component: myRoles },
    { path: '/clients', component: myClient },
    { path: '/firms', component: myFirm },
    { path: '/cases', component: myCase },

    { path: '/calendar', component: myCalendar },
    { path: '/files', component: myFiles },
    // { path: '/test', component: myTest },

]
const router = new VueRouter({
    // mode: 'history',
    routes // short for `routes: routes`
})
// var csrf_token = $('meta[name="csrf-token"]').attr('content');

const app = new Vue({
    el: '#app',
    // token: csrf_token,
    store,
    router,
    components: {
        myHeader, myUser, myClient, myFirm, myCase, myCalendar, myFiles,
        // myTest
    },


    // headers: {
    //     'X-Requested-With': 'XMLHttpRequest',
    //     'Authorization': 'Bearer ...'
    // },
    // default headers example
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': 'set laravel csrf token here...'
    },

    baseUrl: 'http://127.0.0.1:8002/file-manager/',  // overwrite base url Axios
    windowsConfig: 2,
    // lang: 'de',                                 // set language
    translation: {                              // add new translation
        // name: de,
        content: {
            about: 'Über',
            back: 'Zurück',
            // ... see lang file structure
        },
    },


});
