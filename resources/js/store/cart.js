
import Vue from 'vue';
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store ({
    state: {
        pokemons_cart: [],
        
    },
    mutations: {
        setPokemon(state, pokemons) { // pyload =  lista de pokemons a comprar
            // state.pokemons_cart = pokemon // state.pokemons = pokemosn a comprar
            state.pokemons_cart=pokemons

        },
        setAddPoke(state, pokemon){
            state.pokemons_cart.push(pokemon)
            // state.pokemons_cart[pokemon.id]=pokemon
        },
        setDelPoke(state, pokemon){
            var array=[]
            for (let x=0; x<state.pokemons_cart.length; x++){
                if(state.pokemons_cart[x].id != pokemon.id){
                    array.push(state.pokemons_cart[x])
                }
            }
            state.pokemons_cart=array
        },
        setResetCart(state){
            state.pokemons_cart=[]
        }


    },
    actions: {
        async fetcCart({commit}) { // llamado a la API
                await fetch('/api/cart/getCart')
                .then(res => {
                   // console.log(res, 'respuesta c')
                        return res.json()
                })
                .then (json => {
                    //console.log(json)
                    if (json.length==0){
                        commit('setPokemon',[])
                    } else{
                        //console.log(json.data, 'es eso')
                        commit('setPokemon',json.data)
                    }
                })
     
                
        },
        // addPoke({commit,state}, pokemon){
        async addPoke({commit}, pokemon){
            await commit('setAddPoke',pokemon)
        },
        
        async delPoke({commit}, pokemon){
            // console.log("DEL CARRITPO")
            // state.carrito.hasOwnProperty(pokemon.id)
            // ? pokemon.cantidad = state.carrito[pokemon.id].cantidad + 1: pokemon.cantidad = 1
            // pokemon.cantidad = 1 // agrego propiedad cantidad
            // console.log(pokemon,"stroe addPoke")
            await commit('setDelPoke',pokemon)
        },
        async resetCart({commit}){
            await commit('setResetCart')
        }




    },

})