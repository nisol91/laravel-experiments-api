/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import router from "./routes";
import VueRouter from "vue-router";
import index from "./index"
import moment from "moment";
import Vuex from 'vuex'
import storeDefinition from './store'
import VueMapbox from "vue-mapbox";
import Mapbox from "mapbox-gl";
import vuetify from './vuetify'
import inViewportDirective from "vue-in-viewport-directive";
import { messages } from "./locales/translations"
import VueI18n from 'vue-i18n'
import VueMeta from 'vue-meta'
import Vue from 'vue'



//----

import StarRating from './shared/components/StarRating'
import FatalError from './shared/components/FatalError'
import ValidationErrors from './shared/components/ValidationErrors'
import Success from './shared/components/Success'
import SuccessBanner from './shared/components/SuccessBanner'
import NotFound from './shared/components/NotFound'
import ButtonCheck from './shared/components/ButtonCheck'
import MapboxMap from './shared/components/MapboxMap'
import MapboxSearch from './shared/components/MapboxSearch'
import UserSettings from "../js/user/UserSettings"
import ModalForm from "../js/shared/components/ModalForm.vue"
import DeleteForm from "../js/shared/components/DeleteForm.vue"
import CustomSelect from "../js/shared/components/CustomSelect.vue"
import ModalConfirmDelete from "../js/shared/components/ModalConfirmDelete.vue"
import FileLoader from "../js/shared/components/FileLoader.vue"
import SelectLocale from './locales/SelectLocale.vue'



window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(Vuex)
Vue.use(VueMapbox, { mapboxgl: Mapbox });
Vue.use(VueI18n)

Vue.use(VueMeta, {
    // optional pluginOptions
    refreshOnceOnNavigation: true
})



Vue.directive("in-viewport", inViewportDirective);



// define filters globally
Vue.filter('fromNow', value => moment(value).fromNow())

// register components that i want to be registered globally, such as shared components
Vue.component('star-rating', StarRating);
Vue.component('fatal-error', FatalError);
Vue.component('v-errors', ValidationErrors);
Vue.component('success', Success);
Vue.component('success-banner', SuccessBanner);
Vue.component('not-found', NotFound);
Vue.component('button-check', ButtonCheck);
Vue.component('mapbox-map', MapboxMap);
Vue.component('mapbox-search', MapboxSearch);
Vue.component('user-settings', UserSettings);
Vue.component('modal-form', ModalForm);
Vue.component('delete-form', DeleteForm);
Vue.component('custom-select', CustomSelect);
Vue.component('modal-confirm-delete', ModalConfirmDelete);
Vue.component('file-loader', FileLoader);
Vue.component('select-locale', SelectLocale);







// per disabilitare le dev tools in production
// Vue.config.devtools = false;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


// I don't need to register components because I have registered index globally
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// vuex
const store = new Vuex.Store(storeDefinition)


// axios interceptor: always called when it gets a response back from the server
window.axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        // 401 e unauthorized, cioe se scade la sessione. se scade faccio logout
        if (error.response.status === 401) {
            // ci accedo direttamente dalla const store qua sopra
            store.dispatch("logout");
        }

        // questo e il comportamento di default
        return Promise.reject(error);
    }
);

// i18n
// const messages = {
//     en: {
//         message: {
//             hello: 'Hello, {name}!'
//         }
//     },
//     de: {
//         message: {
//             hello: 'Guten Tag, {name}!'
//         }
//     }
// };

const i18n = new VueI18n({
    locale: 'en',
    messages
});

// app

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    i18n,
    components: {
        'index': index
    },
    async beforeCreate() {
        // load data stored in session if there are some
        this.$store.dispatch('loadStoredState')
        this.$store.dispatch('loadUser')

    },
});
