<template>
  <div>
    <button type="button" class="btn btn-success space" v-on:click="mostrar">Choose Avatar</button>
      <div v-if="choose" class="galeria">
        <input type="radio" name="navegacion" id="_1" value="Usul.webp" v-model="img_name" v-on:click="pas_name('Usul.webp')">
        <input type="radio" name="navegacion" id="_2" value="Aura.webp" v-on:click="pas_name('Aura.webp')">
        <input type="radio" name="navegacion" id="_3" value="Bruno.webp" v-on:click="pas_name('Bruno.webp')">
        <input type="radio" name="navegacion" id="_4" value="Hoja.webp" v-on:click="pas_name('Hoja.webp')"> 
        <img :src="route+'Usul.webp'" width="230" height="300" alt="Galeria CSS 1" />
        <img :src="route+'Aura.webp'" width="230" height="300" alt="Galeria CSS 2"  />
        <img :src="route+'Bruno.webp'" width="230" height="300" alt="Galeria CSS 3" />
        <img :src="route+'Hoja.webp'" width="230" height="300" alt="Galeria CSS 4" />
    </div>
</div>
</template>
<script>
export default {
    data() {
        return {
          choose: false,
          img_name: "Usul.webp",
          route:"/images/"
        }
    },
    methods: {
      mostrar(){
        //console.log(this.choose ,'choose')
        if (!this.choose){
          this.choose=true
        } else {
          this.choose=false
        }
      },
      pas_name(img_name){
        //console.log(img_name)
        this.$emit("captura",img_name)
      }
    },
    computed: {
    }
};

</script>
<style>
.galeria {
  height: calc( 300px + 3em);
  width: 260px;
  margin:1em auto;
  border: 1px solid #555;
  position: relative;  
}

.galeria img {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  transition: opacity 3s;
}

.galeria input[type=radio] {
  position: relative;
  bottom: calc(-300px - 1.5em);
  left: .5em;
}

.galeria input[type=radio]:nth-of-type(1):checked ~ img:nth-of-type(1) {
  opacity: 1;
}

.galeria input[type=radio]:nth-of-type(2):checked ~ img:nth-of-type(2) {
  opacity: 1;
}

.galeria input[type=radio]:nth-of-type(3):checked ~ img:nth-of-type(3) {
  opacity: 1;
}

.galeria input[type=radio]:nth-of-type(4):checked ~ img:nth-of-type(4) {
  opacity: 1;
}

.space{
  margin-top: 0.8vh;
}

</style>
