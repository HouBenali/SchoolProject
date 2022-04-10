<template>
 <div class="wrap">
<div id="battle" >  
  
  <div class="battle-arena" :style=" {'background-image': 'url('+mapa+')','background-size': '100% 100%'} ">
    <div class="tutorial-card-opponent">
    <Card :Attacked="attacked" :HP="opponent.hp" :maxHP="opponent.maxHP" :Name="opponent.name" :ATK="opponent.atk" :DEF="opponent.def" :SPD="opponent.spd"
     :Img="opponent.image_path" :Type="opponent.type" :Level="opponent.level" :HPBar="opponent.HPBar" ></Card>
    </div>
    <div class="tutorial-card-player">
    <Card :OPAttacked="opAttacked" :HP="player.hp" :maxHP="player.maxHP" :Name="player.name" :ATK="player.atk" :DEF="player.def" :SPD="player.spd" :Img="player.image_path" 
          :Type="player.type" :Level="player.level" :HPBar="player.HPBar" :Player="player" :IconsPath="IconsPath"></Card>
    </div>
    
    <div class="bottom-menu">
        <div class="battle-text text-box-left">
            {{battleText}}
      </div>
          <div class="text-box-right">
            <div v-if="options" id="battleOptions">
                <div @click="selectOption(1)" class="option-1">{{battleOptions[0]}}</div>
                <div @click="selectOption(2)" class="option-2">{{battleOptions[1]}}</div>
                <div @click="selectOption(3)" class="option-3">{{battleOptions[2]}}</div>
                <div @click="selectOption(4)" class="option-4">{{battleOptions[3]}}</div>
            </div>
            <div v-if="attacks" id="attackOptions">
                <div @click="selectAttack(1)" class="option-1">{{player.moves[0].name}}</div>
                <div @click="selectAttack(2)" class="option-2">{{player.moves[1].name}}</div>
                <div @click="selectAttack(3)" class="option-3">{{player.moves[2].name}}</div>
                <div @click="selectAttack(4)" class="option-4"> {{player.moves[3].name}}</div>
                
            </div>
            <div v-if="disabledOptions" id="battleOptions">
            </div>
            
        </div>
    </div>
  </div>

</div> 
 </div>
</template>

<script>
import axios from 'axios';
import Card from './Card';
import Vue from 'vue';
import user from '../store/store'

export default {
  name: 'Tutorial',
  components:{
    Card,

  },
  
  data(){
    return{
        opponent:{},
        player:{
            name: this.$route.name,
        },

        IconsPath: '',
        battleText: "What will "+ this.$route.name+ " do?",
        battleOptions: ["Fight", "Cards", "Item", "Run"],
        menu: 'options',
        attacks: false,
        options: true,
        disabledOptions: false,
        matchEndOptions:["Yes", "No"],
        turn: true,
        matchEnded: false,
        timeOut:'',
        mapa: 'https://raw.githubusercontent.com/HoussamBenali/Assets/main/images/Fondos/Grassland.jpg',
        maxedHP:false,
        maxedATK:false,
        maxedDEF:false,
        opmaxedHP:false,
        opmaxedATK:false,
        opmaxedDEF:false,
        attacked:false,
        opAttacked:false,

    }
  },
  
  mounted() {  
      
      this.getPokeData()

      this.player.name=this.$route.name;
      
    },
methods: {

        async getPokeData(){
                const resB = await axios.get('/api/pokemon/1')
                let Bulbasaur = resB.data.data

                Vue.set(Bulbasaur, "HPBar",  {width: '100%'})
                Vue.set(Bulbasaur, "maxHP",  Bulbasaur.hp)
                Vue.set(Bulbasaur, "HPlimit", Bulbasaur.hp*1.2)
                Vue.set(Bulbasaur, "maxATK",  Bulbasaur.atk*1.2)
                Vue.set(Bulbasaur, "maxDEF",  Bulbasaur.def*1.2)                

                const resC= await axios.get('/api/pokemon/4')
                let Charmander = resC.data.data
                
                Vue.set(Charmander, "HPBar",  {width: '100%'})
                Vue.set(Charmander, "maxHP",  Charmander.hp)
                Vue.set(Charmander, "HPlimit", Charmander.hp*1.2)
                Vue.set(Charmander, "maxATK",  Charmander.atk*1.2)
                Vue.set(Charmander, "maxDEF",  Charmander.def*1.2)

                const resS = await axios.get('/api/pokemon/'+7)
                let Squirtle = resS.data.data
              
                Vue.set(Squirtle, "HPBar",  {width: '100%'})
                Vue.set(Squirtle, "maxHP",  Squirtle.hp)
                Vue.set(Squirtle, "HPlimit", Squirtle.hp*1.2)
                Vue.set(Squirtle, "maxATK",  Squirtle.atk*1.2)
                Vue.set(Squirtle, "maxDEF",  Squirtle.def*1.2)

          if (this.player.name == "Bulbasaur"){
                this.player=Bulbasaur
                this.opponent = Charmander
           

          } else if (this.player.name == 'Charmander'){
                this.player = Charmander
                this.opponent = Squirtle

            } else{
                this.player = Squirtle
                this.opponent = Bulbasaur
            }
      
        },

        faintAnimation(){
          this.attacks = false
          this.options = false
          this.matchEnded = true;
          if (this.player.hp==0){
            //console.log('rewarded')
            this.SetFirstPokemon(this.player.id);
            this.SetCreateFirstDeck()
            setTimeout(() => {this.battleText = "You have no more cards left!"},2000)
            setTimeout(() => {this.battleText = "You took "+this.player.name+" and ran away!"},4000)
            setTimeout(() => { this.$router.replace('/home')},6000)
          }
          else{
            this.SetFirstPokemon(this.player.id);
            this.SetCreateFirstDeck()
            setTimeout(() => {this.battleText = "You received "+ this.player.name+"!"},2000)
            setTimeout(() => { this.$router.replace('/home')},4000)
          }        
 
      },

      async SetCreateFirstDeck(){
          const res = await axios.post('/api/createDeck',{
              id: this.player.id
          })

      },

      async SetFirstPokemon(id){
        await axios.post('/api/setPokemon/'+id) 
        return user.dispatch('getUser');
           
      },
      
      Fainted(poke){
        if(poke.hp <= 0){
            return true
        } else{
            return false
          }
      },

      selectOption(option) {
        if (option == 1){
            this.attacks= true;
            this.options= false;
            this.battleText='Choose your attack.';
            
        } else if (option ==2){
            this.battleText = "You're our only hope " + this.player.name + "!";
            this.timeOut=setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"}, 2000);

        }else if (option==3){
            this.battleText = "No items in bag.";
            this.timeOut=setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"}, 2000);
          
        }else if (option==4){
            this.battleText = "Can't escape.";
            this.timeOut=setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"}, 2000);
       
        }
      },

  selectAttack(attack) {       
        this.attacks = false
        this.disabledOptions = true
        var skill=this.player.moves[attack-1].power
        if (isNaN(skill)){
            if (skill=="ATK"){
              if(this.player.atk<this.player.maxATK){
                this.player.atk = this.player.atk*1.2
              } else{ this.maxedATK=true }
            } else if (skill=="DEF"){
                if(this.player.def<this.player.maxDEF){
                  this.player.def = this.player.def*1.2
                } 
                else{ this.maxedDEF=true }   
            } else if (skill=="HP"){
              if(this.player.maxHP<this.player.HPlimit){
                  this.player.maxHP = this.player.maxHP*1.2
                  this.player.hp= this.player.hp*1.2
                } 
              else{ this.maxedHP=true }
            }
        }else{
          let realDamage=Math.round(((skill + this.player.atk)/2) - this.opponent.def)
          if (realDamage<=0){
              realDamage=1
          }
          this.attacked = true;
          setTimeout(() => {this.attacked=false},2000)
          this.opponent.hp -= realDamage
          var percent=Math.round(this.opponent.hp/this.opponent.maxHP*100)
        }  

        if(this.Fainted(this.opponent)){
              this.opponent.hp=0
              this.opponent.HPBar = {width: '0%'}  
              this.battleText = this.player.name + " used " + this.player.moves[attack-1].name + "!"
              setTimeout(() => {this.battleText = this.opponent.name + " has fainted! ", this.faintAnimation()},2000)                    
        } 
         //Si usuari segueix amb vida
        else{
            this.opponent.HPBar.width =percent + "%"
            if(isNaN(skill)){
              if (skill=="ATK" && this.maxedATK || skill=="DEF" && this.maxedDEF || skill=="HP" && this.maxedHP ){
                  this.battleText = this.player.name + " used " + this.player.moves[attack-1].name + "!"
                  setTimeout(() => {this.battleText = this.player.name + " can't increase his "+ skill+"anymore!"}, 2000)
                  setTimeout(() => {this.opponentAttack()}, 4000)
                  setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"},6000)

              } else{
                this.battleText = this.player.name + " used " + this.player.moves[attack-1].name + "!"
                setTimeout(() => {this.battleText = this.player.name + " increased his "+ skill+"!"}, 2000)
                setTimeout(() => {this.opponentAttack()}, 4000)
                setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"},6000)
              }
            }
            else{   
             this.battleText = this.player.name + " used " + this.player.moves[attack-1].name + "!"
             setTimeout(() => {this.opponentAttack()}, 2000)
             setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"},4000)     
            }
        }
       
  },

opponentAttack(){
  
  var random = Math.floor((Math.random() * 4) + 1)
  var opponentSkill=this.opponent.moves[random-1].power
 
  if (isNaN(opponentSkill)){
        if (opponentSkill=="ATK"){
              if(this.opponent.atk<this.opponent.maxATK){
                this.opponent.atk = this.opponent.atk*1.2
              } else{
                this.opmaxedATK=true
              }
      
        } else if (opponentSkill=="DEF"){
              if(this.opponent.def<this.opponent.maxDEF){
                this.opponent.def = this.opponent.def*1.2
              }else{
                this.opmaxedDEF=true
              }
        } else if (opponentSkill=="HP"){
            if(this.opponent.maxHP<this.opponent.HPlimit){
                this.opponent.maxHP = this.opponent.maxHP*1.2
                this.opponent.hp = this.opponent.hp*1.2
              }else{
                this.opmaxedHP=true
              }
        }
  }else{
          let realDamage=Math.round(((opponentSkill + this.opponent.atk)/2) - this.player.def)
          if (realDamage<=0){
            realDamage=1
          }
          this.opAttacked = true;
          setTimeout(() => {this.opAttacked=false},2000)
          this.player.hp -=  realDamage
          var percent=Math.round(this.player.hp/this.player.maxHP*100)
      }          
      if(this.Fainted(this.player)){
          this.player.hp=0
          this.player.HPBar = {width: '0%'}
          this.battleText = this.opponent.name + " used " + this.opponent.moves[random-1].name + "!" 
          setTimeout(() => {this.battleText = this.player.name + " has fainted!", this.faintAnimation()},2000)
          
      } else{
          this.player.HPBar.width = percent + "%"
          if(isNaN(opponentSkill)){
             this.battleText = this.opponent.name + " used " + this.opponent.moves[random-1].name + "!"
             if (opponentSkill=="ATK" && this.opmaxedATK || opponentSkill=="DEF" && this.opmaxedDEF || opponentSkill=="HP" && this.opmaxedHP ){
                  setTimeout(() => {this.battleText = this.opponent.name + " can't increase his "+ skill+"anymore!"}, 2000)
              } else{
                setTimeout(() => {this.battleText = this.opponent.name + " increased his "+ opponentSkill+"!"},2000)
              }    
              setTimeout(() => { this.options = true, this.disabledOptions = false},4000)
              setTimeout(() => {this.battleText = "What will " + this.player.name + " do?"},4000)    
          }
          else{
            this.battleText = this.opponent.name + " used " + this.opponent.moves[random-1].name + "!"
            setTimeout(() => {this.options = true, this.disabledOptions = false},2000)
          }          
      
    } 
          
    },

        
    }
}


</script>


<style scoped lang="css">
@import "../../css/tutorial.css";
@import "../../css/tutorialMobile.css";


</style>

