<template>
    <div class="col-4 mx-auto mt-5">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <form class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" @submit.prevent="submitLogin">
                        <div class="mb-3 fv-plugins-icon-container">
                            <label for="email" class="form-label">{{ $t('trans.Email') }} {{ $t('trans.or') }} {{
                                $t('trans.Username') }}</label>
                            <input type="text" class="form-control" id="email" name="email-username"
                                placeholder="Enter your email or username" autofocus="" v-model="loginForm.email" />
                            <div v-for="message in validationErrors?.email">
                                {{ message }}
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">{{ $t('trans.Password') }}</label>
                                <a href="javascript::void(0)">
                                    <router-link :to="{ name: 'forgotPassword' }"> <small>{{ $t('trans.Forgot') }} {{
                                        $t('trans.Password') }}?</small></router-link>
                                </a>
                            </div>
                            <div class="input-group input-group-merge has-validation">
                                <input type="password" id="password" v-model="loginForm.password" class="form-control"
                                    name="password" placeholder="············" aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <div v-for="message in validationErrors?.password">
                                {{ message }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me"
                                    v-model="loginForm.remember" />
                                <label class="form-check-label" for="remember-me">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit" :disabled="processing">Sign
                                in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import useAuth from '../../composables/auth';
const { loginForm, validationErrors, processing, submitLogin } = useAuth()
</script>
<style scoped>
.logo {
    height: 80px;
    text-align: center;
    display: block;
}
</style>
