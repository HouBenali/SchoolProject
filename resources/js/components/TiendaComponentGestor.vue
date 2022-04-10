
<template>
    <div class="poke_container">
        <div class="row row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-1 g-2 g-lg-3">
            <span v-for="pokemon in pokemons" :key="pokemon.id">
                <span v-if="exist_pokeCart(pokemon)">
                    <div class="col hi">
                        <div class="card carta" >
                                <img class="card-img-top" :src="pokemon.image_path" style=" filter: grayscale(100%);">
                                <div class="incart">In cart</div>
                                <span class="card-name">{{ pokemon.name }}</span>
                                <span class="card-name">Price: {{ pokemon.price }}</span>
                                <div>
                                    <span class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#centralModalInfo" @click="getPokemon(pokemon)"  >
                                        Ver
                                    </span>
                                </div>
                        </div>
                    </div>
                </span>
                <span v-else-if="exist_userCards(pokemon.id)">
                    <div class="col hi">
                        <div class="card carta">
                                <div class="haveit">Already have it</div>
                                <img class="card-img-top" :src="pokemon.image_path"  alt="bulbasaur" style=" filter: grayscale(100%);">
                                <span class="card-name">{{ pokemon.name }}</span>
                                <span class="card-name">Price: {{ pokemon.price }}</span>
                                <div>
                                    <span class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#centralModalInfo" @click="getPokemon(pokemon)"  >
                                        Ver
                                    </span>
                                </div>
                        </div>
                    </div>
                </span>
                
                <span v-else>
                <!-- {{pokemons_cart[0]}} -->
                    <div class="col hi">
                        <div class="card carta" v-if="coins_total >= pokemon.price" :style="cardColor(pokemon.rarity)">
                            <img class="card-img-top" :src="pokemon.image_path" >
                            <span class="card-name">{{ pokemon.name }}</span>
                            <span class="card-name">Price: {{ pokemon.price }}</span>
                                <div>
                                    <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#centralModalInfo" @click="getPokemon(pokemon)"  >
                                        Ver
                                    </span>
                                    <button class="btn btn-primary" @click="addPokemon(pokemon)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div> 
                        </div>
                        <div class="card carta" v-else :style="cardColor(pokemon.rarity)">
                            <!-- <span> -->
                            <img class="card-img-top" :src=pokemon.image_path > 
                            <span class="card-name">{{ pokemon.name }}</span>
                            <span class="card-name" style="color: red">Price: {{ pokemon.price }}</span>
                                <div>
                                    <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#centralModalInfo" @click="getPokemon(pokemon)"  >
                                        Ver
                                    </span>
                                    <button class="btn btn-primary" @click="addPokemon(pokemon)" disabled>
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div> 
                            <!-- </span> -->
                        </div>
                    </div>
                </span>
            </span>

            <div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-notify modal-info" role="document">
                    <div class="card cartaInfo" :style="cardColor(pokeInfo.rarity)">
                        <img class="card-img-top-info" :src="pokeInfo.image_path"  alt="bulbasaur">
                            <span class="card-name-info">{{ pokeInfo.name }}</span>
                            <span class="card-text-info">ATK: {{ pokeInfo.atk }}</span>
                            <span class="card-text-info">DEF: {{ pokeInfo.def }}</span>
                            <span class="card-text-info">SPD: {{ pokeInfo.spd }}</span>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
            <hr>
            <v-pagination 
                class="mt-3"
                v-model="currentPage" 
                :page-count="total"
                :classes="bootstrapPaginationClasses"
                :labels="paginationAnchorTexts">
            </v-pagination>  
            </div>
        </div>
    
</div>

</template>

<script>
import vPagination from 'vue-plain-pagination'
import BaulComponent from './Carrito'
import cart from '../store/cart'
import user from '../store/store'
    export default {
        components: { vPagination, BaulComponent },
        name: 'PokemonComponent',
        props: ['pokemons','total'],
        mounted () {
            
        },
        
        data: function () {
            return {
                user:user.state.user,
                cards:null,
                pokeInfo:"",
                currentPage: 1,
                bootstrapPaginationClasses: {
                    ul: 'pagination',
                    li: 'page-item',
                    liActive: 'active',
                    liDisable: 'disabled',
                    button: 'page-link'  
                },
                paginationAnchorTexts: {
                    first: '',
                    prev: '&lsaquo;',
                    next: '&rsaquo;',
                    last: ''
                },
                objec:{
                    ob1:{
                        name:"1"
                    },
                    ob2:{
                        name:"2"
                    }
                }
            }
        },
        methods: {
            getPokemon (pokemon) {
                this.pokeInfo = pokemon
                //console.log(this.pokeInfo)
            },
            async addPokemon (pokemon) { // todo lo que usemos en la vista hay que retornarlo
                await axios.post('api/cart/addpoke',{
                    id_poke:pokemon.id
                })
                await axios.post('api/user/restarPrice',{
                    price:pokemon.price
                })

                user.dispatch('add_poke',pokemon.price)
                cart.dispatch('addPoke',pokemon)
 
                return pokemon
            },
            exist_pokeCart(poke){
                for (let x = 0; x < this.pokemons_cart.length; x++) {
                    var boolea = null
                    if (this.pokemons_cart[x].id == poke.id){
                        boolea = true
                        break
                    }else{
                        boolea = false
                    }
                }
                return boolea
            },
            exist_userCards(poke_id){
              
                // console.log(this.pokemons_cart)
                var pokeList=this.user_cards.split(',')
                for (let x = 0; x < pokeList.length; x++) {
                    // console.log(this.user_cards[x] == poke_id,"User Cards")
                    // console.log(this.user_cards[x], poke_id,"User Cards")
                    var boolea = null
                    if (pokeList[x] == poke_id){
                        boolea = true
                        break
                    }else{
                        boolea = false
                    }
                }
                return boolea
            },
            cardColor(rarity){
                if (rarity=="common"){
                    return  {"background-image": "linear-gradient( to top left, white, gray, white)"}
                }
                else if (rarity=="rare"){
                    return  {"background-image": "linear-gradient(to top left, white, #009933 , white )"}
                }
                else if (rarity=="superrare"){
                    return  {"background-image": "linear-gradient(to top left, white, blue , white )"}
                }
                else if (rarity=="unique"){
                    return  {"background-image": "linear-gradient(to top left, white, #cc00cc, white )"}
                }
                else if (rarity=="legend"){
                    return  {"background-image": "linear-gradient(to top left, white, orange , white )"}
                }
            }
        },

        computed:{
            pokemons_cart: function () {
                //console.log(cart.state.pokemons_cart,"computed_Pokemon")
                return cart.state.pokemons_cart
                },
            
            coins_total: function () {
                //console.log("coin total")
                return user.state.monedas
            },
            user_cards: function () {
                return user.state.cards
            },

    
        },
        watch:{
            currentPage (newVal, oldVal){
                //console.log(newVal)
                this.$emit('getCurrentPage',newVal)
            },
        },
        mounted (){
            //console.log(cart.state.pokemons_cart,"estat cart")
            
            this.cards=user.state.cards.split(',')
        }
        
    }
</script>
<style  scoped>
    /* // @import '~vue-awesome-notifications/dist/styles/style.scss'; */

.poke_container{
    width: 100%;
    align-content: center;
    margin-top: 50px;
    margin-left:50px;
    max-width:95%;
    /* background: black; */
}

img{
    width:130px;
    height:130px;
}

@media (min-width: 630px) {

.cartaInfo{
    min-width: 120px;
    /* max-width: 150px; */
    width: 15vw;
    height: 455px;
    font-size: 40px;
    background: linear-gradient( to top left, rgb(77, 76, 76), white, rgb(90, 90, 90));
    background-size:300% 300%;
    margin: 0vw;
    margin-bottom: 20px;
    border-radius: 5px;
    border: solid black 2px !important;
    animation: reflect 3s infinite linear;
    /*animation-direction: alternate;*/
}

.carta{
    min-width: 120px;
    /* max-width: 150px; */
    width: 10vw;
    height: 235px;
    font-size: 40px;
    background: linear-gradient( to top left, rgb(77, 76, 76), white, rgb(90, 90, 90));
    background-size:300% 300%;
    margin: 0vw;
    margin-bottom: 20px;
    border-radius: 5px;
    border: solid black 2px !important;
    animation: reflect 3s infinite linear;
    /*animation-direction: alternate;*/
}

@keyframes reflect {
    0% {
        background-position: 0% 50%;
    }
    100% {
        background-position: 100% 50% ;
    }
}
.card-img-top{
    border: none !important;
    margin-left: auto;
    margin-right: auto;
    margin-top: 5px;
    margin-bottom: 5px;
    width: 9vw; 
    height: 130px;
    background: transparent !important;

}

.card-img-top-info{
    border: black 0px solid;
    margin-left: auto;
    margin-right: auto;
    margin-top: 5px;
    margin-bottom: 5px;
    width: 12vw; 
    height: 160px;
    /* background-color: white; */
}

.behind{
    min-width: 120px;
    max-width: 150px;
    width: 10vw;
    max-height: 205px;
    height: 205px;
}

.behind-card-name{
    padding-top: 0.5vh;
    padding-bottom: 0.5vh;
    margin: 0px;
    background-color: black;
    color: white;
    font-size: 30%;
}


.card:focus{
    border: solid 4px blue !important;
}


.card-name{
    margin: 0px;
    background-color: black;
    color: white;
    font-size: 30%;
}
.card-name-info{
    margin: 0px;
    background-color: black;
    color: white;
    font-size: 60%;
}


.card-text{
    border-bottom: solid 2px black;
    font-size: 30%;
    text-decoration: none;
}

.card-text-info{
    border-bottom: solid 2px black;
    font-size: 60%;
    text-decoration: none;
}

.card-attack{
    font-size: 30%;
}

.center{
    display: flex;
    align-items: center;
    justify-content: center;
}

.types-icon{
    max-width: 18px;
    margin-bottom: 0.1vh;
}

.hp{
    position: relative;
    display: block;
    text-align: center;
    opacity: 1;
    color: white;
    font-size: 13px;
    font-family: "Roboto Condensed";
}

.incart{
    position: absolute;
    color: red;
    font-size: 12px;
    top: 9px;
    left: 25px;
    transform: translate(-50%, -50%);
}
.haveit{
    position: absolute;
    color: red;
    font-size: 12px;
    top: 9px;
    left: 45px;
    transform: translate(-50%, -50%);

}

}

</style>


