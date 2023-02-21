import './bootstrap';

import {createApp} from 'vue'
import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./router/routes";
 import { i18n } from './i18n'
import axios from 'axios';
import VueAxios from 'vue-axios'
import Swal from 'sweetalert2';
import Form from 'vform';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

window.Form = Form;

const app = createApp({
});
const router = createRouter({
    routes,     
    history: createWebHistory(),
});

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
window.Swal = Swal;
window.Toast = Toast;

app.use(router);
app.use(VueAxios,axios);
app.use(i18n);
app.component('VueDatePicker', VueDatePicker);

router.beforeEach((to, _from, next) => {
  const auth = to.matched.some(record => record.meta.auth);
  if (auth && localStorage.getItem('token') === null ) {
    next({name: 'login'});
  } else if(localStorage.getItem('token') !== null && (to.name === 'login')){
    next({name: 'users'});
    
  }else
    next();

});

axios.interceptors.response.use(
  response => {
    return response
  },
  error => {
    if (error.response.status === 401) {
        localStorage.removeItem('token')
        localStorage.removeItem('uname')
        localStorage.removeItem('uemail')   
        localStorage.clear();               
        window.location.href='/login'
        }
    if (error.response.status === 419) {
          localStorage.removeItem('token')
          localStorage.removeItem('uname')
          localStorage.removeItem('uemail')  
          localStorage.clear();         
          window.location.href='/login'
    }
    return Promise.reject(error)
  }
)

axios.defaults.baseURL = process.env.MIX_API_URL
window.vm = app.mount("#app");

//createApp(App).mount("#app")