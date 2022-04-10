
<template>
<div id="adventure">
  <div class="chooseArea">CHOOSE YOUR ADVENTURE AREA</div>
    <div class="flex-container maps">
      <div type="button" @click="selectMap(1)" class="sewers map" name="Sewers">
        <span class="span">Sewers</span>
      </div>  
      <div type="button" @click="selectMap(2)" class="grassland map" name="Grassland"><span class="span">Grassland</span></div>
      <div type="button" @click="selectMap(3)" class="forest map"><span class="span">Forest</span></div>  
      <div type="button" @click="selectMap(4)" class="desert map"><span class="span">Desert</span></div>
      <div type="button" @click="selectMap(5)" class="cave map"><span class="span">Cave</span></div>
      <div type="button" @click="selectMap(6)" class="volcano map"><span class="span">Volcano</span></div>
      <div type="button" @click="selectMap(7)" class="iceCave map"><span class="span">Ice Cave</span></div>
      <div type="button" @click="selectMap(8)" class="sea map"><span class="span">Sea</span></div>
  </div>

</div>
</template>

<script>
//import axios from 'axios';
//import $ from 'jquery';

export default {
  name: 'Adventure',  
  data(){
    return{
    }
  },


  methods:{
    selectMap(map){
      if (map == 1){ this.$router.push('wildMap/Sewers') }
      else if (map==2){ this.$router.push('wildMap/Grassland') }
      else if (map==3){ this.$router.push('wildMap/Forest') }
      else if (map==4){ this.$router.push('wildMap/Desert') }
      else if (map==5){ this.$router.push('wildMap/Cave') }
      else if (map==6){ this.$router.push('wildMap/Volcano') }
      else if (map==7){ this.$router.push('wildMap/IceCave') }
      else if (map==8){ this.$router.push('wildMap/Sea') }
    }
  }

}

</script>

<style scoped lang="scss">
  @import "../../css/adventure.css";
  @import "../../css/adventureMobile.css";

  #adventure{
    background-color: #2c3e50;
    height: fit-content;
    text-align: center;
  }
  .span{
    display: block;
    position: relative;
    color: honeydew;
    margin-top: 25vh;
    padding: 2vh;
    background-color: slategray;
    border-bottom-left-radius: 1vh;
    border-bottom-right-radius: 1vh;
    border: 5px solid silver;
  }

  .span:hover{
      position: relative;
      width:100%;
  }

  .maps{
        border: 5px solid silver;
        border-top:none;
  }
  

</style>
