<template>
    <div class="main">
        <div class="container0">
        <form @submit.prevent="changePass" class="form">
            <div v-if="message.length > 0" class="alert alert-danger" role="alert">
                {{ message }}
            </div>
            <h2><b>Change Password</b></h2>
            <hr>
            <div class="form-group">
                <label for="opassword">Old Password:</label>
                <input type="password" class="form-control" v-model="form.opassword" name="opassword" id="opassword" required >
            </div>
            <BaseInput
                label="New password"
                type="password"
                v-model="$v.form.password.$model"
                :validator="$v.form.password"
            ></BaseInput>

            <BaseInput
                label="Confirm password"
                type="password"
                v-model="$v.form.rpassword.$model"
                :validator="$v.form.rpassword"
            ></BaseInput>
            <button
                :disabled="!formValidate"
                type="submit"
                class="btn btn-primary"
            >
                Enviar
            </button>
        </form>
        </div>
    </div>
</template>
<script>
import { required, minLength, sameAs, email } from "vuelidate/lib/validators";
import BaseInput from "./BaseInput.vue";

export default {
    components: { BaseInput },
    data() {
        return {
            message:'',
            error:'',
            form: {
                nick: "",
                email: "",
                password: "",
                rpassword: "",
                opassword: ""
            }
        };
    },
    validations: {
        form: {
            password: {
                required,
                minLength: minLength(8)
            },
            rpassword: {
                required,
                sameAsPassword: sameAs("password")
            },
            opassword: {
                required
            }
        }
    },
    methods: {
        async changePass() {
            // console.log("enviar"+ this.formValidate)
            if (this.formValidate) {
                //console.log(this.form);
                //console.log("Form sent");
                //console.log(this.$v.form.opassword.$model)

                const res= await axios.post("/api/changePass", {
                        password: this.$v.form.password.$model,
                        rpassword: this.$v.form.rpassword.$model,
                        opassword: this.$v.form.opassword.$model
                    })

                if (res.data.data=="exito"){
                this.message =""
                //console.log('Exito')
                this.$awn.success("Your password has been updated");
                } else{
                    this.message = "Wrong password";
                }
                    
            }
        },
    },
    computed: {
        formValidate() {
            return !this.$v.$invalid;

            // return  this.form.nick.length > 0 &&
            //         this.form.email.length > 0 &&
            //         this.form.password.length > 4 &&
            //         this.form.rpassword == this.form.password
        }
    },
}
</script>

<style scoped>
.main{
    background-color: #f6f7c7;
    position: relative;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 85vh;
}

h2{
    padding-top: 2vh;
}

  .alert{
	margin-top:2vh;
  }

 
  h2{
	margin-top:2vh;
  }
 
  .container0{
	margin-top: 0;
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