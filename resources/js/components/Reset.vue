<template>
<div id="reset">
  <div class="container0">
    <form class="form" @submit.prevent="Reset">
        <h2><b>Reset</b></h2>
        <hr>
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
    
        <button type="submit" class="registerbtn">Reset</button>
    </form>
  </div>   
</div>
</template>

<script>
import axios from 'axios';
import { required, minLength, sameAs} from 'vuelidate/lib/validators';
import BaseInput from "../components/BaseInput.vue";

export default {
  name: 'Reset',
  components:{
    BaseInput
  },
  data(){
    return{
      form:{
      password: '',
      rpassword:'',
      }
    }
  },
  validations: {
        form: {
            password: {
                required,
                minLength: minLength(8)
            },
            rpassword: {
                required,
                sameAsPassword: sameAs('password')
            }
        }
    },
  methods: {
    async Reset(){
      const response = await axios.post('reset',{
            password: this.$v.form.$model.password,
            password_confirm: this.$v.form.$model.rpassword,
            token:this.$route.params.token,
            });

            if (response.status ==200)
                //console.log('Success');
                this.$router.push('/login');

        
      
    },

  },
}

</script>

<style scoped lang="scss">
 @import "../../css/styles.css";

#reset{
  background-color: #f6f7c7;
  display: block;
  width: 100%;
  height: 90vh;

}

h2{
  margin-top:2vh;
}

.psw{
  padding: 12.5px;
  padding-bottom: 5px;
}

.container0{
  margin-top: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.container1{
  min-width: 280px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color:#f1f1f1;
  margin-top: 1vh;
}


/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  border-radius: 1vh;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

/* Add a hover effect for buttons */
button:hover {
  opacity: 0.8;
}


.mybtn{
  margin-bottom: 0;
}


</style>
