<template>
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa bx bx-menu"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                

                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <img src="" alt="">{{ auth.user?.name }}
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <router-link :to="{ name: 'profile' }" class="dropdown-item">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </router-link>
                            <router-link class="dropdown-item" :to="{ name: 'user.logs' }">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Activity Log</span>
                            </router-link>
                            <a class="dropdown-item" @click="logout">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                    </div>
                </li>
                <LanguageSelector />
            </ul>
        </nav>
    </div>
</template>
<script setup>
import useAuth from "../../composables/auth";
import { userStore } from "../../stores/user";
import { collect } from "collect.js";
import LanguageSelector from './LanguageSelector.vue';
const auth = userStore();
const { user, processing, lang, changelocale, logout } = useAuth()
</script>
<style scoped></style>
