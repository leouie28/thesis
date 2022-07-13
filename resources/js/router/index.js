import Axios from 'axios'
import Vue from 'vue'
import Router from 'vue-router'
import admin from './admin'
import customer from './customer'

Vue.use(Router)

// var links = ''

// if(localStorage.role=='admin'){
//   links = admin
// }else{
//   links = customer 
// }


const router = new Router({
    mode: 'history',
    base: '',
    scrollBehavior() {
        return { x: 0, y: 0 }
    },

    routes: [
      {
        path: '/admin/dashboard',
        component: () => import('../pages/admin/dashboard.vue'),
        name: 'admin-dashboard',
        meta: { requireAuth: true },
    },
    {
        path:'/admin/product',
        component:() => import('../pages/admin/product.vue'),
        name:'admin-product',
        meta:{requireAuth:true},
    },
      ...customer,
      {
          path:'/login',
          component: () => import('../layout/login.vue'),
          name:'login'
      }
    ]
})

router.beforeEach((to, from, next) => {
    Axios.get(`/admin-api/check-auth`).then(({data})=>{
        if(to.matched.some(record => record.meta.requireAuth)) {
          if (data) {
            if(localStorage.role == "admin"){
              if(!to.path.includes('admin')){

                Axios.get(`/admin-api/logout`).then(({data})=>{})
                localStorage.role = '0'

                next({
                  name:'login',
                  query: { redirect: to.fullPath }
                });

              }else{
                next();
              }
            }
            else if (localStorage.role == "customer"){
              if(to.path.includes('admin')){

                Axios.get(`/admin-api/logout`).then(({data})=>{})
                localStorage.role = '0'

                next({
                  name:'login',
                  query: { redirect: to.fullPath }
                });

              }else{
                next();
              }
            }else{

              next({
                name:'login',
                query: { redirect: to.fullPath }
              });

            }
          } else {

            next({
              name: 'login',
              query: { redirect: to.fullPath }
            })

          }
        } else {
          next()
        }
    })
  })


export default router