require('./bootstrap');

import Vue from 'vue';
import { BootstrapVue } from 'bootstrap-vue'
import App from './components/App';
import router from './router';
import store from './store';

Vue.use(BootstrapVue);

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')
