<template>
 
<div id="wild">  
  <div v-if="!changing" class="battle-arena" :style="{'background-image': 'url('+MapBackground+')','background-size': '100% 100%'} ">
    <div class="tutorial-card-opponent">
      <Card :Attacked="attacked" :HP="opponent.poke.hp" :maxHP="opponent.poke.maxHP" :Name="opponent.poke.name" :ATK="opponent.poke.atk" 
      :DEF="opponent.poke.def" :SPD="opponent.poke.spd" :Type="opponent.poke.type" :Level="opponent.poke.level" :HPBar="opponent.poke.HPBar"
       :Img="opponent.poke.image_path" :Rarity="opponent.poke.rarity"></Card>
    </div> 

    <div class="tutorial-card-player">
        <Card :OPAttacked="opAttacked" :HP="player.current.hp" :maxHP="player.current.maxHP" :Name="player.current.name" :ATK="player.current.atk" 
        :DEF="player.current.def" :SPD="player.current.spd" :Type="player.current.type" :Level="player.current.level" :HPBar="player.current.HPBar"
        :Player="player.current" :Img="player.current.image_path" :Rarity="player.current.rarity" ></Card>
    </div>
  <div class="bottom-menu">
        <div class="battle-text text-box-left">
            {{battleText}}<br>
            <button v-if="attacks" class="attackback" @click="goBack()">Go Back</button>
        </div>
          <div class="text-box-right">
            <div v-if="options" id="battleOptions">
                <div @click="selectOption(1)" class="option-1">{{battleOptions[0]}}</div>
                <div @click="selectOption(2)" class="option-2">{{battleOptions[1]}}</div>
                <div @click="selectOption(3)" class="option-3">{{battleOptions[2]}}</div>
                <div @click="selectOption(4)" class="option-4">{{battleOptions[3]}}</div>
            </div>
            <div v-if="attacks" id="attackOptions">
                <div @click="selectAttack(1)" class="option-1">{{player.current.moves[0].name}}</div>
                <div @click="selectAttack(2)" class="option-2">{{player.current.moves[1].name}}</div>
                <div @click="selectAttack(3)" class="option-3">{{player.current.moves[2].name}}</div>
                <div @click="selectAttack(4)" class="option-4"> {{player.current.moves[3].name}}</div>
                
            </div>
            <div v-if="disabledOptions" id="battleOptions">
            </div>    
      </div>
    </div>
  </div> 

  <div  v-if="changing" class="deck">
        <div class="change-poke-text">
      {{changeText}}
    </div>
    <div v-for="poke in player.poke" :key="poke.id" class="squad">
        <div @click="changedCard(poke.i)">
          <Card :HP="poke.hp" :maxHP="poke.maxHP" :Name="poke.name" :ATK="poke.atk" :DEF="poke.def" 
          :SPD="poke.spd" :Type="poke.type" :Level="poke.level" :HPBar="poke.HPBar" :Player="player" :Img="poke.image_path">
          </Card>
        </div>
    </div>

    <br>
    <div class="goback">
      <button class="back" @click="goBack()">Go Back</button>
    </div>
  </div>
</div>
            

</template>

<script>
//import axios from 'axios';
import Card from './Card';
import Vue from 'vue';
import axios from 'axios';
import user from '../store/store'
import decks from '../store/decks'


export default {
  name: 'Wild',
  components:{
    Card,

  },
  
  data(){
    return{
         opponent:{
            cards: 1,
            poke: '',
        },
        player:{
            cards: '',
            current: '',
            poke:[],
        },
        battleText: "",
        changeText: "Who will you choose?",
        battleOptions: ["Fight", "Cards", "Item", "Run"],
        attacks: false,
        options: true,
        disabledOptions: false,
        changing: false,
        forced: false,
        matchEnded: false,
        map: this.$route.params.area,
        MapPath: "https://raw.githubusercontent.com/HoussamBenali/Assets/main/images/Fondos/",
        MapBackground: '',
        coins: null,
        droppedPokemon:null,
        turn:"player",
        maxedHP:false,
        maxedATK:false,
        maxedDEF:false,
        opmaxedHP:false,
        opmaxedATK:false,
        opmaxedDEF:false,
        wins:false,
        attacked:false,
        opAttacked:false,
        //maxedSPD:false,


    }
  },

mounted() {  
 
  this.MapBackground=  this.MapPath+this.map+ '.jpg';
  this.getDeck()   
  this.getOpponent()
  // console(this.player.poke)
     
},

methods: {

async getDeck(){
  let Deck = await axios.get('/api/getMainDeck')
  var count = 0
  for (let i = 0; i < Deck.data.length; i++) {
    if (Deck.data[i].id == 152){
      // console.log("NO EXISTE",i)
    }else{
      
      var pokemon=Deck.data[i]
      Vue.set(pokemon, "HPBar", {width: '100%'})
      Vue.set(pokemon, "i", count )
      Vue.set(pokemon, "id", Deck.data[i].id)
      Vue.set(pokemon, "maxHP",  Deck.data[i].hp)
      Vue.set(pokemon, "HPlimit", Deck.data[i].hp*1.2)
      Vue.set(pokemon, "maxATK",  Deck.data[i].atk*1.2)
      Vue.set(pokemon, "maxDEF",  Deck.data[i].def*1.2)
      //Vue.set(pokemon, "maxSPD",  Deck.data[i].spd*1.5)
      this.player.poke.push(pokemon)
      count += 1
    }
     this.player.cards=count;

  }
  //console.log(this.player.poke)

  if (!this.Fainted(this.player.poke[0])){
      this.player.current=this.player.poke[0] 
  } else if (this.Fainted(this.player.poke[0]) && this.player.cards>0){
      this.player.current=this.player.poke[1]
  } else if (this.Fainted(this.player.poke[1]) && this.player.cards>0){
      this.player.current=this.player.poke[2]
  } else if (this.Fainted(this.player.poke[2]) && this.player.cards>0){
      this.player.current=this.player.poke[3]
  }

  this.battleText= "What will "+ this.player.current.name+ " do?"
                
},

changingCard(){
  this.attacks = false
  this.options = false
  this.disabledOptions = false
  this.changing= true
},

goBack(){
  this.attacks = false
  this.options = true
  this.disabledOptions = false
  this.changing= false
},

changedCard(num){
  
  if (this.player.poke[num].id == this.player.current.id && this.player.poke[num].hp!=0){
      this.changeText='You are already using '+this.player.current.name+'!'
      this.timeOut=setTimeout(() => {this.changeText = "Who will you choose?"}, 2000);
  } else if(this.player.poke[num].hp==0){
      this.changeText='This pokeCard is unconscious!'
      this.timeOut=setTimeout(() => {this.changeText = "Who will you choose?"}, 2000);
  }
  else {
      this.options = false
      this.changing= false
      
      this.player.current= this.player.poke[num]
      this.battleText = "I choose you " + this.player.current.name + "!"
      if (this.forced){
        this.timeOut=setTimeout(() => {this.battleText = "What will " +this.player.current.name + " do?"}, 2000);
        this.forced=false
        this.options = true
        this.disabledOptions = false
      }else{
      setTimeout(() => {this.opponentAttack()},2000)
      this.timeOut=setTimeout(() => {this.battleText = "What will " +this.player.current.name + " do?"}, 4000);
      }
    
  }

}, 
          
faintAnimation: function(){
  this.attacks = false
  this.options = false

  if (this.player.cards==0){
      this.matchEnded = true; 
      setTimeout(() => {this.battleText = "You have no more cards left!"},2000)
      setTimeout(() => { this.$router.push('../adventure')},4000)
      //console.log(this.opponent.poke.id, 'hello')
      //console.log(this.player.current.id, 'hello')
      this.setRewards(this.opponent.poke.id,this.player.current.id)
  } else if (this.opponent.cards==0){
        this.wins = true
        this.matchEnded = true; 
        //console.log(this.opponent.poke.id, 'hello')
        //console.log(this.player.current.id, 'hello')
        this.setRewards(this.opponent.poke.id, this.player.current.id)
        //console.log(this.coins)

        if (this.droppedPokemon != null){
           setTimeout(() => {this.battleText = "You have won "+this.coins+" PokeCoins and obtained "+this.opponent.poke.name},2000)
           decks.dispatch('getDecks')
        }
        else{
           setTimeout(() => {this.battleText = "You have won "+this.coins+" PokeCoins"},2000)
        }      
      setTimeout(() => { this.$router.push('../adventure')},4000)
  }
    else {
      this.forced=true
      setTimeout(() => {this.changingCard()},2000) 
  }
        
},

async setRewards(op_id, player_id){
    if (this.wins){
    //console.log(" WINS")
    var min = Math.ceil(0);
    var max = Math.floor(100);
    var chance= Math.floor(Math.random() * (max - min) + min);
  
    // Probabilidad de drop
    if (chance <= 10 ){
      this.droppedPokemon=op_id.toString()
  
    }
    //console.log(this.opponent.poke)
    if (this.opponent.poke.rarity=="common"){
        this.coins=250
    } else if ( this.opponent.poke.rarity=="rare"){
        this.coins=1000
    } else if (this.opponent.poke.rarity=="superrare"){
        this.coins=2500
    } else if (this.opponent.poke.rarity=="unique"){
      this.coins=10000
    }

    //console.log(this.coins, 'coins')
    //console.log(this.droppedPokemon, 'dropped')
    if (this.droppedPokemon==null){
      //console.log(player_id, 'iddddddddd')
      //console.log('only coins')
           await axios.post('../api/setRewards', {
                 coins: this.coins,
                  poke_player: player_id,
                  poke_op: op_id,
                  wins: 1
          })
                            
    } else{
        //console.log(player_id, 'iddddddddd')
        await axios.post('../api/setRewards', {
            coins: this.coins,
            droppedPokemon: this.droppedPokemon,
            poke_player: player_id,
            poke_op: op_id,
            wins: 1
        })
      }
    }
    else{
      //console.log("LOSS")
      const info = await axios.post('../api/setRewards', {
          coins: 100,
          wins: 0,
          poke_player: player_id,
          poke_op: op_id
      })
    }
  
    return user.dispatch('getUser');

},

Fainted(poke){
  if(poke.hp <= 0){
      return true
  }else{
      return false
  }
},

selectOption(option) {
  if (option == 1){
      this.attacks= true;
      this.options= false;
      this.battleText='Choose your attack!';
      
  } else if (option ==2){
      if (this.player.cards==1){
        this.battleText = "You're our only hope " + this.player.current.name + "!";
        setTimeout(() => {this.battleText = "What will " + this.player.current.name + " do?"}, 2000);
      } else {
        this.changingCard()
      }
      
  }else if (option==3){
      this.battleText = "No items in bag.";
      setTimeout(() => {this.battleText = "What will " + this.player.current.name + " do?"}, 2000);
    
  }else if (option==4){
      this.battleText = "You ran away";
      setTimeout(() => {this.$router.push('../adventure')}, 2000);
  
  }
},

selectAttack(attack) {       
        this.attacks = false
        this.disabledOptions = true
        var skill=this.player.current.moves[attack-1].power
        if (isNaN(skill)){
            if (skill=="ATK"){
              if(this.player.current.atk<this.player.current.maxATK){
                this.player.current.atk = this.player.current.atk*1.2
              } else{
                this.maxedATK=true
              }
            } else if (skill=="DEF"){
                if(this.player.current.def<this.player.current.maxDEF){
                  this.player.current.def = this.player.current.def*1.2
                } else{
                  this.maxedDEF=true
                }
              
            } else if (skill=="HP"){
              if(this.player.current.maxHP<this.player.current.HPlimit){
                  this.player.current.maxHP = this.player.current.maxHP*1.2
                  this.player.current.hp= this.player.current.hp*1.2
                } else{
                  this.maxedHP=true
                }
            }
        }else{
          let realDamage=Math.round(((this.player.current.moves[attack-1].power + this.player.current.atk)/2) - this.opponent.poke.def)
          if (realDamage<=0){
              realDamage=1
          }
          this.opponent.poke.hp -= realDamage
          this.attacked = true;
          setTimeout(() => {this.attacked=false},2000)
          var percent=Math.round(this.opponent.poke.hp/this.opponent.poke.maxHP*100)
        }  
        if(this.Fainted(this.opponent.poke)){
              this.opponent.poke.hp=0
              this.opponent.cards -=1
              this.opponent.poke.HPBar = {width: '0%'}  
              this.battleText = this.player.current.name + " used " + this.player.current.moves[attack-1].name + "!"
              setTimeout(() => {this.battleText = this.opponent.poke.name + " has fainted! ", this.faintAnimation()},2000)            
        } 
         //Si usuari segueix amb vida
        else{
            this.opponent.poke.HPBar.width =percent + "%"
            if(isNaN(skill)){
              if (skill=="ATK" && this.maxedATK || skill=="DEF" && this.maxedDEF || skill=="HP" && this.maxedHP ){
                  this.battleText = this.player.current.name + " used " + this.player.current.moves[attack-1].name + "!"
                  setTimeout(() => {this.battleText = this.player.current.name + " can't increase his "+ skill+" anymore!"}, 2000)
                  setTimeout(() => {this.opponentAttack()}, 4000)
                  setTimeout(() => {this.battleText = "What will " + this.player.current.name + " do?"},6000)

              } else{
                this.battleText = this.player.current.name + " used " + this.player.current.moves[attack-1].name + "!"
                setTimeout(() => {this.battleText = this.player.current.name + " increased his "+ skill+"!"}, 2000)
                setTimeout(() => {this.opponentAttack()}, 4000)
                setTimeout(() => {this.battleText = "What will " + this.player.current.name + " do?"},6000)
              }
            }
            else{   
             this.battleText = this.player.current.name + " used " + this.player.current.moves[attack-1].name + "!"
             setTimeout(() => {this.opponentAttack()}, 2000)
             setTimeout(() => {this.battleText = "What will " + this.player.current.name + " do?"},4000)     
            }
        }
       
  },

opponentAttack(){
  
  var random = Math.floor((Math.random() * 4) + 1)
  var opponentSkill=this.opponent.poke.moves[random-1].power
  //console.log(this.opponent.poke.moves[random-1].name)
  if (isNaN(opponentSkill)){
        if (opponentSkill=="ATK"){
              if(this.opponent.poke.atk<this.opponent.poke.maxATK){
                this.opponent.poke.atk = this.opponent.poke.atk*1.2
              } else{
                this.opmaxedATK=true
              }
      
        } else if (opponentSkill=="DEF"){
              if(this.opponent.poke.def<this.opponent.poke.maxDEF){
                this.opponent.poke.def = this.opponent.poke.def*1.2
              }else{
                this.opmaxedDEF=true
              }
        } else if (opponentSkill=="HP"){
            if(this.opponent.poke.maxHP<this.opponent.poke.HPlimit){
                this.opponent.poke.maxHP = this.opponent.poke.maxHP*1.2
                this.opponent.poke.hp = this.opponent.poke.hp*1.2
              }else{
                this.opmaxedHP=true
              }
        }
  }else{
          let realDamage=Math.round(((this.opponent.poke.moves[random-1].power + this.opponent.poke.atk)/2) - this.player.current.def)
          if (realDamage<=0){
            realDamage=1
          }
          this.player.current.hp -=  realDamage
          this.opAttacked = true;
          setTimeout(() => {this.opAttacked=false},2000)
          var percent=Math.round(this.player.current.hp/this.player.current.maxHP*100)
      }
          
      if(this.Fainted(this.player.current)){
          this.player.current.hp=0
          this.player.cards -=1
          this.player.current.HPBar = {width: '0%'}
          this.battleText = this.opponent.poke.name + " used " + this.opponent.poke.moves[random-1].name + "!" 
          setTimeout(() => {this.battleText = this.player.current.name + " has fainted!", this.faintAnimation()},2000)
          
      } else{
          this.player.current.HPBar.width = percent + "%"
          if(isNaN(opponentSkill)){
             
             if (opponentSkill=="ATK" && this.opmaxedATK || opponentSkill=="DEF" && this.opmaxedDEF || opponentSkill=="HP" && this.opmaxedHP ){
                  this.battleText = this.opponent.poke.name + " used " + this.opponent.poke.moves[random-1].name + "!"
                  setTimeout(() => {this.battleText = this.opponent.poke.name + " can't increase his "+ opponentSkill+" anymore!"}, 2000)
                  setTimeout(() => { this.options = true, this.disabledOptions = false},4000)
                  setTimeout(() => {this.battleText = "What will " + this.player.current.name + " do?"},4000)  
              } else{
                setTimeout(() => {this.battleText = this.opponent.poke.name + " increased his "+ opponentSkill+"!"},2000)
                setTimeout(() => { this.options = true, this.disabledOptions = false},4000)
                setTimeout(() => {this.battleText = "What will " + this.player.current.name + " do?"},4000)  
              }    
              
          }
          else{
            this.battleText = this.opponent.poke.name + " used " + this.opponent.poke.moves[random-1].name + "!"
            setTimeout(() => {this.options = true, this.disabledOptions = false},2000)
          }          
      
    } 
          
    },


async getOpponent(){

  var comun = []
  var rare = []
  var superrare = []
  var unique = []

  if (this.map=="Sewers"){
    comun = [19, 23, 41, 88, 109]
    rare=[20, 42, 89, 110]
    superrare=[92]
    unique=[65]
  } else if(this.map=="Grassland"){
    comun = [16, 19,  69, 84, 102 ]
    rare=[1, 29, 32, 43]
    superrare=[44, 111, 128]
    unique=[123] 
  } else if(this.map=="Forest"){
    comun = [10, 13, 46, 48, 114]
    rare=[11, 14, 56]
    superrare=[12, 15]
    unique=[127]
  } else if(this.map=="Desert"){
    comun = [23, 50, 74]
    rare=[27, 95]
    superrare=[24, 75, 104]
    unique=[122]
  } else if(this.map=="Cave"){
    comun = [41, 46, 50, 74]
    rare=[27, 42, 95]
    superrare=[35, 75, 138, 140]
    unique=[142]
  } else if(this.map=="Volcano"){
    comun = [41, 77]
    rare=[4, 42]
    superrare=[37, 58, 126]
    unique=[137]
  } else if(this.map=="IceCave"){
    comun = [86 ,79]
    rare=[124, 90, 60]
    superrare=[87]
    unique=[131]
  } else if(this.map=="Sea"){
    comun = [54, 72, 79, 98, 129]
    rare=[7, 90, 118]
    superrare=[116, 120, 147]
    unique=[25]
  }

  var ids=[comun,rare,superrare, unique]
  var min = Math.ceil(0);
  var max = Math.floor(100);
  var chance= Math.floor(Math.random() * (max - min) + min);

  if (chance < 70){
    var id= ids[0][Math.floor((Math.random() * ids[0].length))]
    //console.log(70+'%')
  }   
  else if (chance >=70 && chance < 90){
    var id= ids[1][Math.floor((Math.random() * ids[1].length))]
        //console.log(20+'%')
    }
  else if (chance >=90 && chance < 98){
  var id= ids[2][Math.floor((Math.random() * ids[2].length))]
      //console.log(8+'%')
  } else{
  var id= ids[3][Math.floor((Math.random() * ids[3].length))]
      //console.log(2+'%')
  }

  var rival= await axios.get('/api/pokemon/'+id)
  this.opponent.poke= rival.data.data
  Vue.set(this.opponent.poke, "HPBar",  {width: '100%'})
  Vue.set(this.opponent.poke, "maxHP",  rival.data.data.hp)
  Vue.set(this.opponent.poke, "HPlimit",  rival.data.data.hp*1.2)
  Vue.set(this.opponent.poke, "maxATK",  rival.data.data.atk*1.2)
  Vue.set(this.opponent.poke, "maxDEF",  rival.data.data.def*1.2)
  //Vue.set(this.opponent.poke, "maxSPD",  rival.data.data.spd*1.5)

},
    
},

}


</script>

<style scoped lang="css">

.deck{
    position: relative;
    flex: 1 1 1 33%;
    justify-content:space-evenly;
    top:0;
    width: 80vw;
    height: 90vh;
    min-width: 650px;
    min-height: 405px;
    background: white;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    z-index: 0;
    margin-top: 5vh;  
    display: flex;
    flex-wrap: row wrap;

  }
@media (min-width:630px){

  #wild {
    display: flex;
    justify-content: center;
    align-items: center;
    height: max-content;
    overflow:hidden;
  }

}

@media (max-width: 630px) {
  #wild {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    text-align: center;
    height: 100vh;
   
    z-index: 0;
    overflow-y: hidden;

  }

  .battle-arena{
    width: 100%;
  }

  .attackback{
    margin-top: 0.5vh;
    border-radius: 1vh;
    position:absolute;
    padding: 2vh;
    right:5px;
    top: 0;

  }


}


</style>
