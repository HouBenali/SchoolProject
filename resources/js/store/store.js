
// window.Vue = require('vue').default;
import Vue from 'vue';
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  
    state:{
        user: null,
        auth: false,
        monedas: 0,
        cards: '',

    },
    getters:{
        isAuthenticated(state){
            return state.auth;
        },

        user: (state) => {
            return state.user;
        },  
        
        cards: (state) => {
            return state.cards;
        },
        
    },
    mutations: {
        SET_USER(state, user){
            state.user = user
            state.auth = Boolean(user) 
            state.monedas = 0
            state.cards = []
            if (state.auth){
                state.monedas = user.coins
                state.cards =  user.pokemon   
            } 
        },

        SET_PRICE_LESS(state, price){
            state.monedas -= price
        },
        
        SET_PRICE_MORE(state, price){
            state.monedas += price
        }
        // SET_USER_CARDS(state)
        // LESS_COINS(state, price){

        // }
        
    },
    actions: {
        
        async login ({ commit, dispatch },credentials) {
            await axios.get('/sanctum/csrf-cookie') //await = espera a que termine la primera peticion
            const log= await axios.post('login',credentials)
            //console.log(log.data)
            if (log.data!=null){
                return dispatch("getUser")    
                .catch(error => {
                    console.log(error)
                })
            }   
        
        },

        async logout ({ dispatch, commit }) {
            
            await axios.post('logout').then(res=>{
                var cookies = document.cookie.split(";");
                //console.log(cookies)
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = cookies[i];
                    var eqPos = cookie.indexOf("=");
                    var name = eqPos > -1 ? cookie.substring(0, eqPos) : cookie;
                    document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
                }
            })
            return commit("SET_USER", null)
   
        },


        async getUser({ commit }) { // commit => sirve para ejecutar una mutacion
            
            await axios.get("/api/user").then(requestOne=>{
            axios.post('/api/setCookie')
            const requestTwo = axios.get("/api/pokesUser");
            axios.all([requestOne.data, requestTwo]).then(axios.spread((...responses) => {
            const responseOne = responses[0]
            const responseTwo = responses[1]
            //console.log(responseOne)
            var usuari=responseOne
            var pokes =responseTwo.data
            //console.log(responseTwo)
            // use/access the results 
            usuari.pokemon=pokes.toString()
            
            //console.log(usuari, 'user');
            commit("SET_USER", usuari)
            }))                       
            })     
           
        },

        async add_poke ({commit}, price){
            await commit('SET_PRICE_LESS',price)
        },

        async del_poke ({commit}, price){
            await commit('SET_PRICE_MORE',price)
        }

        // async update_card ({commit}) {
        //     await commit()
        // }

            
    }

})