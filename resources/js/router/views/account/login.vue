<script>
import useVuelidate from '@vuelidate/core'
import {
  required,
  email, 
  helpers
} from '@vuelidate/validators'
export default {
    setup () {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            form : {
                    email: '',
                    password: '',
                    device_name: 'browser',
                },
            errors:{},     
            submitted: false,
            showPassword: false,
        };
    },
    validations: {
        form: {            
            email: { 
                required: helpers.withMessage('users.Email is required', required),
                email: helpers.withMessage('users.Email is invalid', email),                
            },     
            password: {
                required: helpers.withMessage('users.Password is required', required),                   
            },            
        },
    },
    methods:{
        toggleShow() {
            this.showPassword = !this.showPassword;
        },
        login() {            
           
            this.submitted = true;
            // stop here if form is invalid      
            this.v$.$touch();
            if (this.v$.$invalid) {
                return;
            }
            axios.post('login',this.form).
            then((response) => { 
                localStorage.setItem('token',response.data.token)
                localStorage.setItem('uname',response.data.name)
                localStorage.setItem('uemail',response.data.email)
                localStorage.setItem('urole',response.data.role)
                localStorage.setItem('role_key',response.data.role_key)
                localStorage.setItem('role_name',response.data.role_name)                
                 localStorage.setItem('userid',response.data.userid)
                Toast.fire({
                    icon: "success",
                    title: this.$t(response.data.message),
                });
                this.$router.push('/dashboard')               
                
            })
            .catch(errors => {                
                let email_msg = "";
                if(!errors.response.data.success){
                    email_msg = this.$t(errors.response.data.message);
                    this.errors = { 
                            email:email_msg                            
                    }
                }else{
                    this.errors = {}
                }
               
            })
    
        }
    },
}
</script>
<template>
    <div class="auth-fluid">
            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body">

                        <!-- Logo -->
                        <div class="auth-brand text-center text-lg-start">
                            <a href="/" class="logo-dark">
                                <span><img src="assets/images/logo-dark.png" alt="" height="22"></span>
                            </a>
                            <a href="/" class="logo-light">
                                <span><img src="assets/images/logo-dark.png" alt="" height="22"></span>
                            </a>
                        </div>

                        <!-- title-->
                        <h4 class="mt-0 mb-3">{{$t("login.Sign In")}}</h4>
                        <!-- form -->
                        <form action="#"  @submit.prevent="login">
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">{{$t("login.Email address")}}</label>
                                <input class="form-control" id="emailaddress" v-model="form.email" :class="{ 'is-invalid': submitted && v$.form.email.$error }" :placeholder="$t('login.Enter your email')" autocomplete="on">
                                <div class="invalid-feedback" v-for="(error, index) of v$.form.email.$errors" :key="index" autocomplete="off">
                                    <div class="error-msg">{{  $t(error.$message) }}</div>                      
                                </div>
                                <p v-if="v$.form.email.$errors.length == 0" class="text-danger" v-text="errors.email"></p>
                            </div>
                            <div class="mb-3">
                                <!-- <router-link to="/forgot-password" class="text-muted float-end"><small>{{$t("login.Forgot your password")}}</small></router-link>                                 -->
                                <label for="password" class="form-label">{{$t("login.Password")}}</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" :type="showPassword ? 'text' : 'password'" v-model="form.password" id="password" :class="{ 'is-invalid': submitted && v$.form.password.$error }" :placeholder="$t('login.Enter your password')" autocomplete="off">
                                    <div class="input-group-text" :class="{ 'show-password': showPassword  }" :data-password="showPassword" @click="toggleShow">
                                        <span class="password-eye"></span>
                                    </div>
                                    <div class="invalid-feedback" v-for="(error, index) of v$.form.password.$errors" :key="index" autocomplete="off">
                                        <div class="error-msg">{{  $t(error.$message) }}</div>                      
                                    </div>
                                    <p class="text-danger" v-text="errors.password"></p>
                                </div>
                                
                            </div>                            
                            <div class="d-grid mb-0 text-center">
                                <button class="btn btn-primary" type="submit"><em class="mdi mdi-login"></em> {{$t("login.Log In")}} </button>
                            </div>
                        </form>
                        <!-- end form-->

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->
        </div>
</template>
