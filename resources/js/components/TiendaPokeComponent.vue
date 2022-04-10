<template>
<div>
<div class="chooseArea">POKESHOP</div>
<div class="tienda">

    <div class="container">
            <pokemon-component v-if="total > 0"
                :pokemons="pokemons"
                :total="total"
                @getCurrentPage="getCurrentPage"
                @addPokemon="addPokemon"
                >
            </pokemon-component>
    </div>

    <div class="baul">
            <baul-component>
                
            </baul-component>
    </div>
 
</div>
</div>
</template>

<script>
import PokemonComponent from './TiendaComponentGestor';
import BaulComponent from './Carrito';
    export default {
        components: { PokemonComponent, BaulComponent },
        
        name: 'TiendaPokeComponent',
        created () {
            this.getPoke();
        },
        data: function () {
            return {
                pokemons: [],
                total:0,
                currentPage:1,
                pokeAdd:[],
            }
        },
        methods:{
            async getPoke () {
                // this.$awn.asyncBlock(fetch('/api/pokemon?page='+this.currentPage)
                await fetch('/api/pokemon?page='+this.currentPage)
                .then(response => {
                    return response.json()
                    })
                .then(json => {
                    //console.log(json.data,"paginacion");
                    //console.log(json.data)
                    this.pokemons = json.data.data;
                    this.total = json.data.last_page
                    // console.log(this.total)
                    })
                .catch (error => {
                    console.log("ERROR ",error);
                    return this.$router.push('signin')
                })
            },
            getCurrentPage (page){
                this.currentPage=page
                //console.log("pokeList: "+page)
                this.getPoke()
            },
            addPokemon(poke){
                //console.log(poke,"tienda")
                this.pokeAdd.push(poke)
            }
        },

    }
</script>
<style scoped>
.tienda{
    color: white;
    display: flex;
    width: 100%;
    height: 100%;
}

.container{
    border: 5px solid silver;
    border-top:none;
    width: 70%;
    max-width: none;
    overflow: auto;
}
.baul{
    border: 5px solid silver;
    border-top:none;
    border-left:none;
    background: #343a40 !important;
    width: 30%;
}
</style>