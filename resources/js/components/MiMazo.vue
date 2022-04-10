<template>
<div>
<div class="chooseArea">CUSTOMIZE YOUR DECK</div>
<div class="decks" >

    <div class="container">
        <!-- DECKS POKEBOLAS -->
        <span v-for="(deck,i) in user_deks" :key="deck.id">
            <div class="marginarriba btn sidebarindex "  >
                <span v-if="main==i" class="marginderecha">
                <i  class="fas fa-star"></i> 
                </span>
                <div @click="showDeck(i)" style="display:flex; align-items:center">
                    <img v-if="main!=i" class="icon" :src="img"/> {{ deck[1] }} 
                </div>
 
                <i class="fas fa-edit mb-1 text-danger btn" @click="renameDeck(i)"></i>

                <i class="fa fa-trash mb-1 text-danger btn" @click="deleteDeck(i)"></i>
   
            </div>
        </span> 
        
        <div v-if="maxDecks()" class="marginarriba marginabajo sidebarindex btn">
            <div class="" @click="newDeck"> Add New Deck</div>
        </div>

    </div>
<!-- DECK INDIVIDUAL -->
    <div class="main" >
        <div v-if="current_deck" class="current_deck">
     
            <div class="row row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-2 hueco">
                <div v-for="card in current_deck">
                    <span v-if="minOnePokeDeck()">
                            <div class="col">
                                <div v-if="card.id==152" class="card carta" :style="cardColor(card.rarity)" >
                                </div>
                                <div v-else class="card carta" :style="cardColor(card.rarity)">
                                    <img class="card-img-top img" :src="card.image_path" >
                                    <span class="card-name">{{ card.name }}</span>
                                </div>
                            </div>

                        </span>
                        <span v-else>
                            <div class="col">
                                <div v-if="card.id==152" class="card carta" :style="cardColor(card.rarity)" >
                                </div>
                                <div v-else class="card carta" :style="cardColor(card.rarity)">
                                    <img class="card-img-top img" :src="card.image_path" >
                                    <span class="card-name">{{ card.name }}</span>
                                    <div class="mibtn">
                                        <button class="btn minus" @click="dropPokemon(card)" > 
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div> 
                                </div>
                            </div>
                        </span> 
                </div>
    
            </div>

            <div class="botonMain" v-if="show">
                <div v-if="this.main==this.deckID" >
                </div> 
                 <div v-else>
                    <button class="btn changeMainDeck" @click="changeMainDeck"> 
                       Set as Main
                    </button>
                </div> 
            </div>
        </div>
        
    <!-- TUS CARTAS -->
        <div v-if="user_pokes" class="pokes">
            <div class="row row-cols-lg-5 row-cols-md-4 row-cols-sm-3 row-cols-2 g-2 g-lg-3 subpokes">
                <div v-for="(card) in user_pokes" v-bind:key="card.id">
                    <span v-if="existInDeck(card.id)">
                     <div class="col">
                            <div class="card carta" :style="cardColor(card.rarity)">
                                <img class="card-img-top img" :src="card.image_path" >
                                <span class="card-name" >{{ card.name }}</span>
                                    <div class="mibtn">
                                        <button class="btn plus" @click="addPokemon(card)"> 
                                            <i class="fas fa-plus" ></i>
                                        </button>
                                    </div> 
                            </div>
                     </div>
                    </span>
                    <span v-else>
                    <div class="col">
                            <div class="card carta" style=" filter: grayscale(100%);">
                                <img class="card-img-top img" :src="card.image_path">
                                <span class="card-name" >  
                                        {{card.name}}
                                </span>
                            </div>
                    </div>
                    </span>
                </div>
            </div>
        </div> 
</div>
</div>
</div>
</template>

<script>
import axios from "axios";
import Vue from 'vue';
import decksStore from '../store/decks' 

export default {

    data(){
        return{
            decks: [],
            //deckInfo: '',
            img:'https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Pok%C3%A9_Ball_icon.svg/1200px-Pok%C3%A9_Ball_icon.svg.png',
            cards:'',
            user_cards:[],
            deckID:null,
            existe:true,
            main:'',
            show:false,
            IconsPath: 'https://raw.githubusercontent.com/HoussamBenali/Assets/main/images/Types/',
            nom:'',
            
        }
    },
    methods: {
        async newDeck(){
             const res = await axios.post('/api/createDeck')
             decksStore.dispatch('getDecks')
             
        },

        async changeMainDeck(){
            const res = await axios.post('/api/changeMainDeck', {
                id:this.deckID})
            decksStore.dispatch('getDecks')
            this.isMain()
        },

        async isMain(){
             const res = await axios.get('/api/isMainDeck')
             this.main=res.data
             
        },

        async deleteDeck(id){
            const res = await axios.post('/api/deleteDeck', {
                id:id})
            
            if (res.data){
                this.$awn.warning("You can't delete your main deck!")
            }else{
                this.$awn.success("Deleted succcessfully")
            }
             decksStore.dispatch('getDecks')
        },

        showDeck(id){
            this.deckID=id
            this.show=true
            decksStore.dispatch('showDeck',id)
            decksStore.dispatch('showPokes')
            
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

        },

        async addPokemon(poke){
            const res = await axios.post('/api/addPokeDeck',{
                id: poke.id,
                deck_id: this.deckID
            })
            decksStore.dispatch('showDeck',this.deckID)
        },

        async dropPokemon(poke){
            const res = await axios.post('/api/dropPokeDeck',{
                id: poke.id,
                deck_id: this.deckID
            })
            decksStore.dispatch('showDeck',this.deckID)
        },

        existInDeck (id) {
        //    console.log(this.current_deck);
        //    console.log(id)
            for (let x = 0; x < this.current_deck.length; x++) {
                var boolea = null
                if (this.current_deck[x].id == id ){
                    boolea = false
                    break
                }else if (this.deckFull()){
                    boolea = true
                }else{
                    boolea = false
                    break
                }
            }
            return boolea
        },

        deckFull(){
            var current_id=[]
            for (let x = 0; x < this.current_deck.length; x++) {
                current_id.push(this.current_deck[x].id)
            }
            if ( current_id.includes(152)){
                return true
            }else{
                return false
            }
        },

        minOnePokeDeck(){

            var num = 0;
            for (let x = 0; x < this.current_deck.length; x++) {
                if (this.current_deck[x].id == 152){
                        num=num+1
                    }
            }
     
            if (num == 3){return true}
            else{return false}
        },

        maxDecks(){
            var num = this.user_deks_Count
                if (num>=8){return false}
                else{return true}
        },

    async renameDeck(deck_id){
        var isOk = false
        await this.$prompt("","", "Change this deck's name" ).then(text => {
            if (text.length>8){
                this.$awn.warning("Name must have a maximum of 8 characters")
            }else{
                //console.log(text, 'text')
                axios.post('api/renameDeck',{
                    id: deck_id,
                    nombre: text
                }).then( res =>{
                    //console.log(res.data)
                    if (res.data == "Success"){
                        isOk = true
                        decksStore.dispatch('getDecks')  
                    }
                if (isOk){
                    this.$awn.success("Name changed successfully")
                }
                
                })
                
            }
             
        }).catch(e=>{
            //console.log(e)
        })

       

        }

    },
    computed: {
        user_deks: function () {
            return decksStore.state.decks
        },

        user_deks_Count: function() {
        var num=0
        const object = decksStore.state.decks
        for (var element in object){
            num=num+1  
        }
      
        return num;

        },

        user_pokes: function () {
            return decksStore.state.pokes
        },
        current_deck: function () {
            return decksStore.state.deckInfo
        },
    },
   
    mounted(){
        this.isMain()
        decksStore.dispatch('getDecks')
    }
}
</script>
<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>

<style scoped lang="css">
.main{
    background: #343a40 !important;
    width: 85%;
    min-height: 100%;
    border: 5px solid silver;
    border-top:none;
    border-left:none;
    display: flex;
    flex-wrap: wrap;
    
}

.current_deck{
    background: #343a40;
    min-width: 180px;
    min-height: 250px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 5px solid silver;
    border-right: none;
    border-left: none;
    border-top: none;

}

.changeMainDeck{
    position: relative;
    background: darkblue;
    color: white;
    border: white solid 1px;
    max-width: 150px;
    /*top:10vh;*/
    padding:8px !important;

}

.hueco{
    display: flex;
}

.decks{
    margin:0;
    padding: 0;
    display: flex;
    width: 100%;
    min-height: calc(100vh - 180px);
    height: fit-content;
}

.container{
    position: sticky;
    width: 15%;
    min-width: 240px;
    max-width: none;
    background-color: #343a40;
    border: 5px solid silver;
    border-top:none;
}

.plus{
    background:green;
}
.minus{
    background-color: tomato;
}

.btn{
    position: relative;
    padding:0;
    padding-left: 4px;
    padding-right: 4px;
}

.mibtn{
    margin-top: 0.5vh;
    line-height: 0px;
}



.img{display: flex;
    width:100px;
    height: 100px;
}

.icon{
    display: flex;
    width:50px;
    height: 50px;
    margin-right: 5px;
}

.pokes{
    border: 5px solid silver;
    border-top:none;
    border-right: none;
    border-left: none;
    border-bottom: none;
    display: flex;
    align-items: center;
    justify-content: center;
   
}

.subpokes{
    display: flex;
    align-items: center;
    justify-content: center;
     margin: 15px;
    
}
.carta{
    margin:15px;
}

.moving-card {
    opacity: 0.5;
    background: #F7FAFC;
    border: 1px solid #4299e1;
}



.sidebarindex{
    
    color: #000;
    padding-top: 1vh;
    padding-bottom: 1vh;
    border-radius: 1vh;
    background: white;
    text-decoration: none;
    display: block;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
    width: 100%;
}

.marginarriba{
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin-top: 5px;
}

.marginabajo{
    margin-bottom: 5px;
}

.marginderecha{
    margin-right: 5px;
}

</style>