<template>
    <div class="col-4 mx-auto mt-5">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <form class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" @submit.prevent="submitForgotPassword">
                        <div class="mb-3 fv-plugins-icon-container">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email-username"
                                    placeholder="Enter your email get Reset link" autofocus=""
                                    v-model="forgotForm.email"/>
                            <div v-for="message in validationErrors?.email" class="error fw-semibold text-danger text-bold mt-2">
                                {{ message }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit" :disabled="processing">Send
                            </button>
                        </div>
                        <input type="hidden"/>
                    </form>
                    <p class="text-center">
                        <span>Have a account ? </span>
                        <router-link :to="{name: 'login'}">
                            <span>Login</span>
                        </router-link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import useAuth from '../../composables/auth';


const {forgotForm, validationErrors, processing, submitForgotPassword} = useAuth()
</script>
<style scoped>

</style>
