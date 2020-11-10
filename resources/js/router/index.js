import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../components/Home';
import EmployeesList from '../components/employees/List';
import EmployeesForm from '../components/employees/Form';
import Error from '../components/errors/Error';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Home,
      name: 'home',
      children: [
        {
          path: 'employees',
          component: EmployeesList,
          name: 'employees-list',
        },
        {
          path: 'employees/new',
          component: EmployeesForm,
          name: 'employees-new',
        },
        {
          path: 'employees/:id',
          component: EmployeesForm,
          name: 'employees-update'
        },
      ],
    },
    {
      path: '*',
      component: Error,
    },
  ],
});

export default router;
