<template>
<div class="mygames">
    <div class="chooseArea">My Game Records</div>
    <!-- {{pedidos}} -->
    <table class="table table-hover table-dark">
        
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Obtained Pokemon</th>
                    <th scope="col">Player Poke</th>
                    <th scope="col">Oponent Poke</th>
                    <th scope="col">Coins</th>
                    <th scope="col">Fecha</th>
                </tr>
            </thead>
            <tbody v-for="game in gamesOff" :key="game.id">
                <tr v-if="game.wins == 1" style="background-color:green;">
                    <th scope="row">{{game.id}}</th>
                    <td>{{game.rewards}}</td>
                    <td><img class="poke_icon" :src="game.uimage_path" alt=""></td>
                    <td><img class="poke_icon" :src="game.oimage_path" alt=""></td>
                    <td>{{game.coins}}</td>
                    <td>{{game.created_at}}</td>
                </tr>
                <tr v-else style="background-color:tomato;">
                    <th scope="row">{{game.id}}</th>
                    <td>{{game.rewards}}</td>
                    <td><img class="poke_icon" :src="game.uimage_path" alt=""></td>
                    <td><img class="poke_icon" :src="game.oimage_path" alt=""></td>
                    <td>{{game.coins}}</td>
                    <td>{{game.created_at}}</td>
                </tr>
            </tbody>
    </table>
</div>
</template>

<script>

import Vue from 'vue';
import helper from '../plugins/mixin'
export default {
    
    name: 'MyGamesOff',
    
    created () {
        this.getGamesOff()

    },
    data: function () {
        return {
            gamesOff:"",
            userPokeID:"",
            opponentPokeID:"",
            pokemon_player:"",
            pokemon_opponent:"",
            baseImage: "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/1.png"
        }
    },
    methods:{
        async getGamesOff () {
            //Obtiene registros db de partidas offline
            await axios.get('/api/user/getGamesOff')
            .then(response => {
                this.gamesOff = response.data;
            })

            for ( let x=0; x<this.gamesOff.length; x++ ) {
                this.userPokeID = this.gamesOff[x].poke_player
                this.opponentPokeID = this.gamesOff[x].poke_op
                Vue.set(this.gamesOff[x], "uimage_path", "")
                Vue.set(this.gamesOff[x], "oimage_path", "")
                await helper.getUserPokemonByID(this.gamesOff[x], this.userPokeID)
                await helper.getOpponentPokemonByID(this.gamesOff[x],this.opponentPokeID);
                var date = new Date(this.gamesOff[x].created_at);
                this.gamesOff[x].created_at = date.toDateString()
            }
            
        }, 

    }
}
</script>




<style scoped>

.mygames{
    color: white;
}


.poke_icon{
    width: 50px;
    height: 50px;
}


</style>