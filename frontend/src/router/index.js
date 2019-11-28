import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import Dashboard from '@/components/Dashboard'
import Doctor from '@/components/Doctor'
import Patient from '@/components/Patient'
import Appointment from '@/components/Appointment'

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
      path: '/doctor',
      name: 'doctor',
      component: Doctor
    },
    {
      path: '/patient',
      name: 'patient',
      component: Patient
    },
    {
      path: '/appointment',
      name: 'appointment',
      component: Appointment
    }
  ]
})
