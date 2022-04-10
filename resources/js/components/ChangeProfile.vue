<template>

<body>
<div id="ChangeForm">
	<div class="container0">
  	 <form class="form" @submit.prevent="changeNick">
        <div v-if="message.length > 0" class="alert alert-danger" role="alert">
            {{ message }}
        </div>
            <h2><b>Change Nick</b></h2>
            <hr>
            <div class="form-group">
                <label for="nick"><b>Nick:</b></label>
                <input type="text" class="form-control" v-model="form.nick" name="nick" id="nick" required >
            </div>
            <button type="submit" class="btn btn-primary">
                Enviar
            </button>
        </form>
	</div>
 	<div class="newUser">
        <form class="form" @submit.prevent="changeEmail" >
        <div v-if="emessage.length > 0" class="alert alert-danger" role="alert">
            {{ emessage }}
        </div>
            <h2><b>Change Email</b></h2>
            <hr>
            <div class="form-group">
                <label for="email"><b>Email:</b></label>
                <input type="text" class="form-control" v-model="form.email"  name="email" id="email" required>
      	    </div>

            <button
                type="submit"
                class="btn btn-primary">
                Enviar
            </button>
        </form>
    	</div>
</div>

</body>

</template>

<script>
import { required, minLength, sameAs, email } from "vuelidate/lib/validators";
import BaseInput from "./BaseInput.vue";
import axios from 'axios';
import store from '../store/store'

export default {
    components: { BaseInput },
    data() {
        return {
            message:"",
            emessage:"",
            form: {
                nick: "",
                email: "",
            }
        };
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
        }
    },
    methods: {
        async changeNick() {
           
            //console.log("Form enviado");
            const res= await axios.post("/api/updateNick", {
                        nick: this.$v.form.nick.$model,
                    })
            //console.log(res.data)
            if (res.data.data=="exito"){
               this.message =""
               //console.log('Exito')
               this.$awn.success("Your nick has been updated");
            } else{
                  this.message = res.data.nick[0];
            }
             
            return store.dispatch('getUser')
        
        },
         async changeEmail() {    
                //console.log("Form enviado");
                var pemail=this.$v.form.email.$model
                var correo=pemail.toLowerCase()
                const res= await axios.post("/api/updateEmail", {
                        email: correo,
                    })
                    
            if (res.data.data=="exito"){
               this.emessage =""
               this.$awn.success("Your email has been updated");
            } else{
                this.emessage = res.data.email[0];
            }
                 
        return store.dispatch('getUser')
       
        },

        getAvatar(nombre) {
            var imagen = "";
            axios
                .get("/avatar/" + nombre)
                .then(function(response) {
                    imagen = response.data;
                })
                .catch(function(error) {
                    fail(error);
                });
            return imagen;
        },
        async getNick(){
            const res=await axios.get('/api/user')
            this.form.nick=res.data.nick
            return res.data.nick
        },

        async getEmail(){
            const res=await axios.get('/api/user')
            this.form.email= res.data.email
            return res.data.email
        }
    },
    computed: {
        formValidate() {
            return !this.$v.$invalid;
        },

    },
      mounted(){
        this.getNick() 
        this.getEmail()
    }




};
</script>


<style scoped>
	#ChangeForm{
    display:block;
	background-color: #f6f7c7;
	width: 100%;
    min-height: 90vh;
	overflow: auto;
	height:fit-content;
	text-align: center;
    align-items: center;
    justify-content: center;   
  }

  .alert{
	margin-top:2vh;
  }
 
  .newUser{
    display:flex;
    align-items: center;
    justify-content: center;
  }
 
 
  h2{
	margin-top:2vh;
  }
 
  .container0{
	margin-top: 5vh;
	display: flex;
	align-items: center;
	justify-content: center;
	width: 100%;
    
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
 
  button:hover {
	opacity: 0.8;
  }
 
  .mybtn{
	margin-bottom: 0;
  }

</style>