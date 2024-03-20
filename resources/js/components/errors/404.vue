<template>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="#" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    🚀
                                </span>
                                <span class="app-brand-text demo text-body fw-bolder text-uppercase">My Pharmacity</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome to Pharmacity! 👋</h4>
                        <p class="mb-4">Please sign-in to your account and start the adventure</p>
                        <h3>
                            404 <br>
                         page not found
                        </h3>
                        <router-link :to="{ name:'dashboard' }" class="btn btn-info">Home</router-link>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
</template>
<script setup>
import useAuth from '../../composables/auth';

const { loginForm, validationErrors, processing, submitLogin } = useAuth()
</script>
<style scoped></style>
