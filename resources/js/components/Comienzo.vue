<template>
<div id="Comenzando">
  <div class="main">
    <h1 class="welcome">
      <span class="centerWelcome">
      Welcome to the world of PokeCards!
      </span>
    </h1>
    <h2>Choose your starter:</h2>
  </div>
  <div>
</div>

<div class="chooseOne">
  <div class="center">

    <router-link class="router" to="Bulbasaur">
    <div @click="isBulbasaur" class="card starting carta">
      <img class="card-img-top" :src="Bulbasaur.image_path" alt="bulbasaur">
      <span class="card-name">{{Bulbasaur.name}}</span>
      <span class="card-text">HP: {{Bulbasaur.hp}}</span>
      <span class="card-text">ATK: {{Bulbasaur.atk}}</span>
      <span class="card-text">DEF: {{Bulbasaur.def}}</span>
      <span class="card-attack">SPD: {{Bulbasaur.spd}}</span>
    </div>
    </router-link>

    <router-link class="router" to="Charmander">
    <div @click="isCharmander" class="card starting carta">
      <img class="card-img-top" :src="Charmander.image_path" alt="charmander">
      <span class="card-name"><img class="types-icon" :src="IconsPath+'Fire.png'" /> 
       Charmander 
     <img class="types-icon" :src="IconsPath+'Fire.png'" /> </span>
      <span class="card-text">HP: {{Charmander.hp}}</span>
      <span class="card-text">ATK: {{Charmander.atk}}</span>
      <span class="card-text">DEF: {{Charmander.def}}</span>
      <span class="card-attack">SPD: {{Charmander.spd}}</span>
    </div>
    </router-link>
    
    <router-link class="router" to="Squirtle">
    <div @click="isSquirtle" class="card starting carta">
      <img class="card-img-top" :src="Squirtle.image_path" alt="squirtle">
      <span class="card-name">{{Squirtle.name}}</span>
      <span class="card-text">HP: {{Squirtle.hp}}</span>
      <span class="card-text">ATK: {{Squirtle.atk}}</span>
      <span class="card-text">DEF: {{Squirtle.def}}</span>
      <span class="card-attack">SPD: {{Squirtle.spd}}</span>
    </div>
    </router-link>
  </div>
</div>
</div>
</template>

<script>
//import axios from 'axios';

import store from '../store/store'
import axios from 'axios';


export default {
  name: 'Comenzando',
  components:{
  },
  data(){
    return{
      pokemon:'',
      Bulbasaur:'',
      Charmander:'',
      Squirtle:'',
      IconsPath: "https://raw.githubusercontent.com/HoussamBenali/Assets/main/images/Types/",
    }
  },
  mounted(){
    //console.log(store.state.user)
    this.getPokeData()
    
  },
  methods:{
    async getPokeData(){
                const resB = await axios.get('/api/pokemon/1')
                //console.log(resB)
                //console.log(resB.data)
                this.Bulbasaur = resB.data.data
                //console.log(this.Bulbasaur)

                const resC= await axios.get('/api/pokemon/4')
                this.Charmander = resC.data.data
              
                const resS = await axios.get('/api/pokemon/'+7)
                this.Squirtle = resS.data.data
  
    },

    isCharmander(){
      return this.pokemon = this.Charmander
    },
    isBulbasaur(){
      return this.pokemon = this.Bulbasaur
    },
    isSquirtle(){
      return this.pokemon = this.Squirtle
    }
  },
  async beforeRouteLeave (to, from, next) {

    let message = {
      title: '<p style="text-align:center">'+ this.pokemon.name+ '</p>',
      body: '<p style="text-align:center"><img width="50" height="50" src="'+ this.pokemon.image_path+'"></p><p style="text-align:center">Are you sure you want to pick '+this.pokemon.name+'?</p>'
    };

    let options = {
          html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
          loader: false, // set to true if you want the dailog to show a loader after click on "proceed"
          //reverse: false, // switch the button positions (left to right, and vise versa)
          okText: 'Continue',
          cancelText: 'Cancel',
          animation: 'zoom', // Available: "zoom", "bounce", "fade"
          type: 'basic', // coming soon: 'soft', 'hard'
          verification: 'continue', // for hard confirm, user will be prompted to type this to enable the proceed button
          //verificationHelp: 'Type "[+:verification]" below to confirm', // Verification help text. [+:verification] will be matched with 'options.verification' (i.e 'Type "continue" below to confirm')
          //clicksCount: 3, // for soft confirm, user will be asked to click on "proceed" btn 3 times before actually proceeding
          //backdropClose: false, // set to true to close the dialog when clicking outside of the dialog window, i.e. click landing on the mask
          //customClass: '' // Custom class to be injected into the parent node for the current dialog instance
      };
      
    await axios.get('/api/pokesUser').then(hasPoke => {
              if (hasPoke.data.length > 0) {  
                next()
              }
              else{
                    if (this.pokemon == ""){
                    //console.log(this.pokemon, 'do nothing')
                  } else {
                        this.$dialog.confirm(message, options)
                        .then(function () {
                        next();
                        })
                        .catch(function () {
                          this.pokemon = ''
                          next();
                        });

                  }
              }
    })



		},

    
    
}


</script>

<style scoped lang="scss">
@import "../../css/cards.css";
@import "../../css/cardsMobile.css";

//background: linear-gradient(45deg, #17ead9, #6078ea);
@media (min-width: 630px) {
.chooseOne{
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
}
.router{
    text-decoration: none !important;
    color: black !important;
    margin-right: 1.5vw !important;
}


.router:hover{

  text-decoration: none;
}

.carta{
    min-width: 120px;
    max-width: 150px;
    width: 10vw;
    height: 220px;
    font-size: 40px;
    background: linear-gradient( to top left, rgb(77, 76, 76), white, rgb(90, 90, 90));
    background-size:300% 300%;
    margin: 0vw;
    border-radius: 5px;
    border: solid black 2px !important;
    animation: reflect 3s infinite linear;
    /*animation-direction: alternate;*/
}
}

</style>
