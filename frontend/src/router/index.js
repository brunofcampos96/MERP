import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import Dashboard from '@/components/Dashboard'
import DoctorDashboard from '@/components/DoctorDashboard'

Vue.use(Router)

export default new Router({
  routes: [
    
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard
    },
    {
      path: '/doctorDashboard',
      name: 'doctor_dashboard',
      component: DoctorDashboard
    }
  ]
})
