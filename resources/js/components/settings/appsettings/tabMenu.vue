<template>
    <div>
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between text-center">
                <h5 class="card-title mt-1">Settings</h5>
                <div class="avatar flex-shrink-0">
                    <i class="bx bxs-cog bx-lg text-info"></i>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills d-block">
                    <li class="nav-item">
                        <button class="nav-link text-start" :class="{ active: selectedTab === 'general' }" @click="selectTab('general')">
                            <i class="bx bx-home me-2"></i>General
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-start" :class="{ active: selectedTab === 'smtp' }" @click="selectTab('smtp')">
                            <i class='bx bxs-envelope me-2'></i>SMTP Setup
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-start" :class="{ active: selectedTab === 'sms' }" @click="selectTab('sms')">
                            <i class="bx bx-mail-send me-2"></i>SMS Setup
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedTab: 'general' // Default selected tab is 'sale'
        };
    },
    methods: {
        selectTab(tab) {
            this.selectedTab = tab;
            this.$emit('tab-selected', tab); // Emit an event to the parent component
        }
    }
};
</script>

<style></style>
