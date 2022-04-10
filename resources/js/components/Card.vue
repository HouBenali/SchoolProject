<template>
        <div class="contenedor" @click="FlipMe" :style="vibrar">
            <div v-if="notFlipped" class="card carta" :style="cardColor">
                <!-- <span class="player-level">Lvl. {{Level}}</span> -->
                <div class="hp-bar">
                    <div v-if="Player" :style="HPStyle" class="hp-bar-fill-player"></div>
                    <div v-if="!Player" :style="HPStyle" class="hp-bar-fill-opponent"></div>
                    <h4 v-if="Player" class="hp">{{HP}}/{{maxHP}}</h4>
                </div> 
                <img class="card-img-top" :src="Img" :alt="Name">
               
                <span class="card-name">
                    <img class="types-icon" :src="getType" />
                        {{Name}}
                    <img class="types-icon" :src="getType" />
                </span>
            </div>
            <div v-else-if="!notFlipped" class="card behind carta">
                 <img class="card-img-top " style="max-width:70px; max-height:70px; min-width:70px; min-width:70px; border:none; background:transparent" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Pok%C3%A9_Ball_icon.svg/1200px-Pok%C3%A9_Ball_icon.svg.png" :alt="Name">
                <span class="behind-card-name">
                    <img class="types-icon" :src="getType" />
                        {{Name}}
                    <img class="types-icon" :src="getType" />
                </span>
                <span class="card-text">ATK: {{ATK}}</span>
                <span class="card-text">DEF: {{DEF}}</span>
                <span class="card-attack">SPD: {{SPD}}</span>
            </div>
        </div>
        

</template>

<script>

export default {
    name: 'Carta',
    data(){
            return {
                IconsPath: 'https://raw.githubusercontent.com/HoussamBenali/Assets/main/images/Types/',
                notFlipped: true,
                IPath: null,      
            };
        },
    props: {
        Player: {},
        Name: {},
        Type: {},
        Level: {},
        HP: {},
        Img: {},
        ATK:{},
        DEF: {},
        SPD: {},
        HpBar: {},
        maxHP: {},
        Rarity:{},
        Attacked:{},
        OPAttacked:{}
    },
    computed: {
            HPStyle(){    
                let color = '#f02b2b';
                        
                if(this.HP >= 0.7*this.maxHP){
                    color = '#33bd96';
                }       
                else if(this.HP >= 0.3*this.maxHP){
                    color = '#ff9012';
                }

                var percent=this.HP/this.maxHP*100
                percent = Math.round(percent)

                if (percent<=0){
                    return {
                        width: '100%',
                        background: 'none',
                        border: "none",                
                    }

                } else {
                    return {
                        width: String(percent) + '%',
                        background: color,
                        border: "1px solid black",
                        }
                }
                
     
            },
                hasHP(){
                    return this.HP > 0;
                },
                getType(){
                    if (this.Type == undefined){
                        //console.log('')//
                    }
                    else{
                         this.IPath= this.IconsPath+this.Type+'.png'
                    }
                    
                return this.IPath
            },
             cardColor(){
                 
                if (this.Rarity=="common"){
                    return  {"background-image": "linear-gradient( to top left, white, gray, white)"}
                }
                  else if (this.Rarity=="rare"){
                    return  {"background-image": "linear-gradient(to top left, white, #009933 , white )"}
                }
                else if (this.Rarity=="superrare"){
                    return  {"background-image": "linear-gradient(to top left, white, blue , white )"}
                }
                else if (this.Rarity=="unique"){
                     return  {"background-image": "linear-gradient(to top left, white, #cc00cc, white )"}
                }
                else if (this.Rarity=="legendary"){
                     return  {"background-image": "linear-gradient(to top left, white, orange , white )"}
                }

            },

            vibrar(){
                if (this.Attacked & !this.Player){
                    return {
                           animation: 'shake 0.5s',
                           'animation-iteration-count': '1'
                    }
                }
                else if(this.OPAttacked){
                     return {
                           animation: 'shake 0.5s',
                           'animation-iteration-count': '1'
                    }
                }
            }

            
        },


        methods: {
             FlipMe(){
                if (this.notFlipped==false){
                    this.notFlipped=true;

                } else {
                     this.notFlipped=false;
                  }
            },
            
           
            
            
    }
}
</script>

<style lang="css">
@import "../../css/cards.css";

@keyframes shake {
  0% { transform: translate(1px, 1px) rotate(0deg); }
  10% { transform: translate(-1px, -2px) rotate(-1deg); }
  20% { transform: translate(-3px, 0px) rotate(1deg); }
  30% { transform: translate(3px, 2px) rotate(0deg); }
  40% { transform: translate(1px, -1px) rotate(1deg); }
  50% { transform: translate(-1px, 2px) rotate(-1deg); }
  60% { transform: translate(-3px, 1px) rotate(0deg); }
  70% { transform: translate(3px, 1px) rotate(-1deg); }
  80% { transform: translate(-1px, -1px) rotate(1deg); }
  90% { transform: translate(1px, 2px) rotate(0deg); }
  100% { transform: translate(1px, -2px) rotate(-1deg); }
}

</style>