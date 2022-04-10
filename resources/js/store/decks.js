
// window.Vue = require('vue').default;
import Vue from 'vue';
import Vuex from 'vuex'
import axios from 'axios'
axios.defaults.withCredentials = true

Vue.use(Vuex)

export default new Vuex.Store({
    state:{
        decks:[],
        pokes:[],
        deckInfo:[],
    },
    getters:{ 
    },

    mutations: {

        SET_DECK(state, array){
            state.decks=array
        },

        SET_SHOWPOKES(state, array){
            // console.log(array,"79846565468")
            state.pokes=array
        },
        SET_DECK_POKE(state, array){
            // console.log(deck,id,"ASDADSADS")
            state.deckInfo=array
        } 
        
    },
    actions: {
        
        async getDecks({commit}){
            const res = await axios.get('/api/getDecks')
            //console.log(res.data,"MYS DECKS")
            commit('SET_DECK', res.data)
        },
        
        async showPokes({commit}){
            const res =  await axios.get('/api/pokesUser')
            var cards=res.data
            var user_cards=[]
            
            for (let index = 0; index < cards.length; index++) {
                const res = await axios.get('/api/pokemon/'+cards[index])
                user_cards.push(res.data.data)
            }
            commit('SET_SHOWPOKES', user_cards)
        },


        async showDeck({commit},id){
            const res= await axios.get('/api/getDeck/'+id)
            // console.log(res.data,"MYS POKES DECK")
        commit('SET_DECK_POKE', res.data)
    },



    }

})