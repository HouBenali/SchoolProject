<template>
    <div class="pokemons"> 
        <div class="chooseArea">Pokemones</div>
        <pre>{{pokemons}}</pre>
        <!-- <pre>{{pokemon}}</pre> -->
    </div>
    
</template>

<script>
import axios from 'axios'
export default {
    data () {
        return {
            pokemons: [],
            pokemon:{},

        }
    },
    methods: {
        newPokemon(){
            this.name = "",
            this.HP = "",
            this.ATK = "",
            this.DEF = "",
            this.SPD = "",
            this.type = "",
            this.moves = [],
            this.image_path = ""
        },
        
        async getPokemons () {
            var urls_poke = []
            await fetch('https://pokeapi.co/api/v2/pokemon?limit=151')
            .then(res => {
                return res.json()
            }).then(json => {
                 console.log(json.results)
                for (let x=0; x<50; x++){
                    urls_poke.push(json.results[x].url)
                }
            })
            console.log(urls_poke)
            this.getPokemon(urls_poke)
        },

        async getPokemon(urls_poke){
            /* Cambiar dependiendo de la cantidad obtenida en getPokemons*/
            for (let x=0; x<151; x++){

                var urls_moves = []
                await fetch(urls_poke[x])
                .then(res => {
                    return res.json()
                })
                .then(json => {
                    this.pokemon = new this.newPokemon()
                   
                    this.pokemon.name= json.name
                    this.pokemon.HP=json.stats[0].base_stat
                    this.pokemon.ATK=json.stats[1].base_stat
                    this.pokemon.DEF=json.stats[2].base_stat
                    this.pokemon.SPD=json.stats[5].base_stat
                    this.pokemon.image_path=json.sprites.other['official-artwork'].front_default
                    this.pokemon.type=json.types[0].type.name

                    if (json.moves.length == 1){
                        urls_moves.push(json.moves[0].move.url)
                    }else{
                        for (let x=0; x<4; x++){
                        urls_moves.push(json.moves[x].move.url)
                        }
                    }
                    //console.log(json.name)
                    return urls_moves
                    
                })
                .then(urls_moves => {
                    var array_moves = this.getMoves(urls_moves)
                    return array_moves
                })
                .then(array_moves => {
                    this.pokemon.moves=array_moves
                    this.pokemons.push(this.pokemon)
                })
            }
            //console.log(this.pokemon)
            this.savePokemons()

        },

        async getMoves(arr) {
            let array_moves = new Array
            if (arr.length == 1){
                //console.log(arr[0])
                await fetch(arr[0])
                .then(res => {
                    return res.json()
                })
                .then(json => {
                    //console.log(json)
                    let _move = {
                        name:json.name,
                        power:json.power
                    }
                    array_moves.push(_move)
                })
            }else{
                for (let x=0; x<4; x++){
                    await fetch(arr[x])
                    .then(res => {
                        return res.json()
                    })
                    .then(json => {
                        var moveName=json.name.split('-')
                        if (moveName.length>1){
                            json.name=moveName[0].charAt(0).toUpperCase()+ moveName[0].slice(1) + ' '+moveName[1].charAt(0).toUpperCase()+ moveName[1].slice(1)
                        }
                        
                        let _move = {
                            name:json.name.charAt(0).toUpperCase()+ json.name.slice(1),
                            power:json.power
                        }
                        //console.log(json.name)
                        array_moves.push(_move)
                    })
                }
            }
            return array_moves
        },

        async savePokemons(){
            for (let x=0; x < this.pokemons.length; x++){
                //console.log(this.pokemons[x])
                let list = []

                for (let i=0; i < this.pokemons[x].moves.length; i++){
                    list.push(JSON.stringify(this.pokemons[x].moves[i]))
                }
                //console.log(list)

                await axios.post('api/pokemon',{
                    name:this.pokemons[x].name.charAt(0).toUpperCase()+ this.pokemons[x].name.slice(1),
                    HP: this.pokemons[x].HP,
                    ATK: this.pokemons[x].ATK,
                    DEF: this.pokemons[x].DEF,
                    SPD: this.pokemons[x].SPD,
                    type: this.pokemons[x].type.charAt(0).toUpperCase()+ this.pokemons[x].type.slice(1),
                    moves:list,
                    image_path: this.pokemons[x].image_path
                })
                .then (response => {
                    //console.log("CORRECTO: ",response.data)
                }).catch (error => {
                   //console.log("ERROR: ",error)
                })
            }
        }
    },
    mounted() {
        console.log('Pokemon montado')
        this.getPokemons()

        }
    }

</script>