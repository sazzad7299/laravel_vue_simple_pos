<template>

    <div class="container body">
        <div class="main_container">
                <Sidebar />
            <div class="top_nav">
                <Navbar />
            </div>
            <div class="right_col" role="main">
                <Preloader />
                <transition name="fade">
                    <router-view></router-view>
                </transition>
            </div>
        

      </div>
    </div>
</template>
  
<script>
import { defineComponent } from 'vue';
import Bottom from "./partials/bottom.vue";
import Sidebar from "./partials/sidebar.vue";
import Navbar from "./partials/navbar.vue";
import Preloader from "./partials/preloader.vue";

export default defineComponent({
    name: "app",
    components: { Navbar, Sidebar, Preloader, Bottom },
});
</script>
  
<style scoped>
.fade-enter-active {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.fade-leave-active {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.fade-enter,
.fade-leave-active.show {
    opacity: 1;
}
</style>
  