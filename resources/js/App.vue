<template>
  <div id="aplication">
 
    <div class="header">
      <!--<Nav></Nav>-->
      <Nav v-if="['login', 'register', 'forgot', 'reset', 'home', 'base', 'adventure', 'profile',
      'shop','myshops','myGamesOff','avatar', 'changePass', 'changeProfile', 'decks'].includes($route.name)"></Nav>
    </div>
    <div class="mainApp">
      <router-view/>
    </div> 
  </div>
</template>

<script>
import Nav from './components/Nav';
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

export default {
  name: 'index',
  components: {
    Nav,
  },   
  
}

</script>

<style lang="scss">

@media (min-width: 630px) {
#aplication {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  background-color: #343a40;
  // background-image: url(https://wallpaper.dog/large/5576984.jpg);
  // background-size:cover;
  //background-position: center 70px;
  min-height: 100vh;
 // height: fit-content;
 /* overflow: hidden;*/
  
}

.header > a{
  color: #2c3e50;
  text-decoration: none;

}
/*
.mainApp{
  width: 100%;
  height: fit-content;
}
*/
}

@media (max-width: 630px){

#aplication {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  background-color: #f6f7c7;
  min-height: 100vh;
  height: fit-content;

  }
}
// .main{
//   background: blue;
// }



</style>