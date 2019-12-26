require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import { routes } from './routes';


// import { OverlayScrollbarsComponent } from 'overlayscrollbars-vue';
// Vue.component('overlay-scrollbars', OverlayScrollbarsComponent);

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('seat-display', require('./components/SeatDisplay.vue').default);
Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('show-alert', require('./components/Alert.vue').default);
Vue.component('high-light', require('./components/Highlighter.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);
Vue.component('expand', require('./components/ExpandButton.vue').default);
Vue.component('add-section', require('./components/AddSection.vue').default);


const router = new VueRouter({
    //linkActiveClass: 'active',
    mode: 'history',
    base: '/admin/',
    routes
});

const app = new Vue({
    el: '#app',    
    router
});
