<template>
<div id="registerForm">
        <div v-if="message.length > 0" class="alert alert-danger" role="alert">
            {{ message }}
        </div>
    <div class="containerRoot">

        <form class="form" @submit.prevent="Register">
            <h2><b>Register</b></h2>
            <hr>
            <div class="form-group">
                <BaseInput label="Nick:" 
                v-model="$v.form.nick.$model"
                :validator = "$v.form.nick"
                ></BaseInput>
            </div>

            <div class="form-group">
                <BaseInput label="Email:" 
                type="email" 
                v-model="$v.form.email.$model"
                :validator = "$v.form.email"
                ></BaseInput>
            </div>
            
            <div class="form-group">
                <BaseInput label="Password:" 
                type="password"
                v-model="$v.form.password.$model"
                :validator = "$v.form.password"
                ></BaseInput>
            </div>

            <div class="form-group">
                <BaseInput label="Confirm password:"
                type="password" 
                v-model="$v.form.rpassword.$model"
                :validator = "$v.form.rpassword"
                ></BaseInput>
            </div>
            <PlantillaAvatar v-on:captura="capturar($event)"></PlantillaAvatar>
            <button 
                :disabled="!formValidate"
                type="submit"
                class="">Enviar
            </button>
            <hr>
        
            <div class="container">
                <label class="psw">
                    <span>Already have an account? <router-link to="login">Sign in</router-link></span>
                </label>
            </div>

        </form>
    </div>

</div>
        <!-- {{ $v.form.$model }} -->
</template>

<script>
import { required, minLength, sameAs, email } from 'vuelidate/lib/validators'
import BaseInput from "../components/BaseInput.vue"
import PlantillaAvatar from "./PlantillaAvatar.vue";
import axios from 'axios'
export default {

    components: {BaseInput, PlantillaAvatar},

    data () {
        return {
            form:{
                nick:"",
                email:"",
                password:"",
                rpassword:"",
            },
            message:"",
            img_name: 'Usul.webp'
        }
        
    },
    validations: {
        form: {
            nick: {
                required,
                minLength: minLength(3)
            },
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(8)
            },
            rpassword: {
                required,
                sameAsPassword: sameAs('password')
            },
        }
    },
    methods: {

        resetForm() {
            this.$v.form.nick.$model = "";
            this.$v.form.email.$model = "";
            this.$v.form.password.$model = "";
            this.$v.form.rpassword.$model = "";

            this.$v.$reset(); //resetear estado

            document
                .querySelectorAll("form.registro input")
                .forEach(e => (e.value = ""));
            // this.$awn.info("Formulario reiniciado");
        },

        Register () {
            // console.log("enviar"+ this.formValidate)
            if (!this.formValidate) return; 

                //console.log(this.form, 'this.form')
                // console.log("Form enviado")
                var email =this.$v.form.email.$model.toLowerCase()

                axios.post('api/register',{
                    nick:this.$v.form.nick.$model,
                    email:email,
                    password:this.$v.form.password.$model,
                    rpassword:this.$v.form.rpassword.$model,
                    image: this.img_name
                }).then (response => {
                    //console.log("RESPUESTA ",response.data);
                    this.resetForm();
                    this.message=""
                    this.$awn.success("Registered Successfully")
                    this.$router.push('login')

                })
                .catch (error => {
                    console.log("ERROR ",error);
                    this.$awn.warning("This email is already registered")
                    this.message="This email is already registered"
                    this.$v.form.email.$model = "";

                })
        },
        
        capturar($datos){
            //console.log($datos)
            this.img_name=$datos
        }
    },
    computed: {
        formValidate () {
            return !this.$v.$invalid
        }
    },
    
    
}
</script>
<style scoped lang="scss">
 
   @import "../../css/styles.css";

#registerForm{
    background-color: #f6f7c7;
    display: block;
    height:fit-content;
    background-image: url(https://assets.pokemon.com/assets/cms2/img/pokedex/full/150.png),url(https://assets.pokemon.com/assets/cms2/img/pokedex/full/151.png);
    background-repeat: no-repeat;
    background-size:auto;
    background-position-x: left ,  right;
    width: 100%;
    height: 85vh !important;
}

h2{
  margin-top:1vh;
}

.psw{
  padding: 12.5px;
  padding-bottom: 5px;
}

.containerRoot{
  margin-top: 0;
  display: flex;
  align-items: center;
  justify-content: center;

}

.container{
  min-width: 270px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color:#f1f1f1;
  position: relative;
  top:5px
}

button {
  background-color: #4CAF50;
  border-radius: 1vh;
  color: white;
  padding: 1.5vh;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

.mybtn{
  margin-bottom: 0;
}

form{
    margin-bottom: vh;
}
</style>