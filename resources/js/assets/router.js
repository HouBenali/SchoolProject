import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import store from "../store/store";
import cart from "../store/cart";
import axios from 'axios';
import helpers from '../plugins/mixin'


// import ExampleComponent from '../components/ExampleComponent'
import RegistroComponent from '../components/RegistroComponent'
import LoginController from '../components/LoginController'
import Forgot from '../components/Forgot';
import Reset from '../components/Reset';
import Home from '../components/Home';
import Comienzo from '../components/Comienzo';
import Tutorial from '../components/Tutorial';
import Adventure from '../components/Adventure';
import WildMap from '../components/WildMap';
import getPokemons from '../components/GetPokemons';
import Avatar from '../components/ChangePhotoComponent';
import Shop from '../components/TiendaPokeComponent';
import MyShops from '../components/MyShopComponent';
import MyGamesOff from '../components/MyGamesOffComponent';
import ChangePass from '../components/ChangePass';
import ChangeProfile from '../components/ChangeProfile';
import Decks from '../components/MiMazo';


Vue.use(VueRouter)

const router = new VueRouter({
    mode:'history',
    base: process.env.BASE_URL,
    routes: [

        { path: '/register', component:  RegistroComponent, name: 'register', meta: { guest: true}},
        { path: '/login', component:  LoginController , name: 'login', meta: { guest: true }},
        { path: '/forgot', name: 'forgot',  component: Forgot , meta:  { guest: true }},
        { path: '/reset/:token', name: 'reset', component: Reset,  meta:  { guest: true }},
        { path: '/', name: 'base', component: () => import(/* webpackChunkName: "Raiz" */"../components/Home.vue"),
         meta: { requiresAuth: true, requiresPokemon: true}},

        { path: '/home', name: 'home', component: Home , meta:{ requiresAuth: true, requiresPokemon: true}},

        { path: '/starting',  name: 'starting', component: Comienzo, meta: { requiresAuth: true, requiresNoPokemon: true } },
        { path: '/Squirtle',  name: 'Squirtle', component: Tutorial, meta: { requiresAuth: true, requiresNoPokemon: true } },
        { path: '/Bulbasaur',  name: 'Bulbasaur', component: Tutorial, meta: { requiresAuth: true, requiresNoPokemon: true } },
        { path: '/Charmander',  name: 'Charmander', component: Tutorial, meta: { requiresAuth: true, requiresNoPokemon: true } },
        { path: '/adventure', name: 'adventure', component: Adventure,  meta: { requiresAuth: true, requiresPokemon: true}},
        { path: '/wildMap/:area', name: 'wildMap', component: WildMap,  meta:  { requiresAuth: true, requiresDoublePath: true,}},
        { path: '/shop', name: 'shop', component: Shop,  meta:  { requiresAuth: true, requiresPokemon: true}},
        { path: '/myshops', name: 'myshops', component: MyShops,  meta:  { requiresAuth: true, requiresPokemon: true}},
        { path: '/myGamesOff', name: 'myGamesOff', component: MyGamesOff,  meta:  { requiresAuth: true, requiresPokemon: true}},
        { path: '/decks', name: 'decks', component: Decks,  meta:  { requiresAuth: true, requiresPokemon: true}},
        { path: '/changeAvatar', name: 'avatar', component: Avatar,  meta:  { requiresAuth: true, requiresPokemon: true}},
        { path: '/changePass', name: 'changePass', component: ChangePass,  meta:  { requiresAuth: true, requiresPokemon: true}},
        { path: '/changeProfile', name: 'changeProfile', component: ChangeProfile,  meta: { requiresAuth: true, requiresPokemon: true}},

        //solo usar path pokemons cuando se quiera obtener datos de la api externa y guardarlos en la DDBB
        // { path: '/pokemons', name: 'pokemons', component:getPokemons,  meta: { requiresAuth: true } },
        
        { path: '*', name: 'error', component: () => import(/* webpackChunkName: "Error" */"../components/Error.vue")},
    ],   
    
})


router.beforeEach( async (to, from, next) => {

var isSet = false
var cks = document.cookie.split(';');
for(var i = 0; i < cks.length; i++){
  if (cks[i].split('=')[0].trim() == "data001") {
    isSet = true
  } 
}
//console.log(isSet)

if (to.matched.some(record => record.meta.guest)) {
 
    if (isSet){    
      next('home')
    } 
  else{  
        next()
    }
} 

if (to.matched.some(record => record.meta.requiresAuth)) { 
  if (isSet){
      store.dispatch("getUser")
        next()
    } 
    else{
        next('login')
      }

} 


if (to.matched.some(record => record.meta.requiresPokemon)) {
    
  if (isSet){
    axios.post('/api/hasPokes').then(res=>{
      //console.log(res.data, 'hasPokes')
      if (res.data > 0) {  
        next()
      } else {
        //console.log(res.data,'NoPoke') 
        next('/starting')
      }
    })     
  }
}
if (to.matched.some(record => record.meta.requiresNoPokemon)) {

  if (isSet){
      axios.post('/api/hasPokes').then(res=>{
        //console.log(res.data, 'hasPokes')
        if (res.data > 0) {  
          next('/home')
        } else {
          //console.log(res.data,'NoPoke') 
          next() 
        }
    })
  }
}

if (to.matched.some(record => record.meta.requiresDoublePath)) {

  if (isSet){
     axios.post('../api/hasPokes').then(res => {
       if (res.data > 0) {  
         next()
       } else {
         next('/starting')
       }
     })
   }
}



});   

export default router
  