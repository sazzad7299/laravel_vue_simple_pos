<template lang="">
    <div>
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-3 h-100">
                    <TabMenu @tab-selected="changeTab" />
                </div>
                <div class="col-md-9">
                    <component :is="selectedTabComponent"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TabMenu from './tabMenu.vue';
import general from './general.vue';
import smtp from './smtp.vue';
import sms from './sms.vue';
export default {
    components: {
        TabMenu,
        smtp,
        general,
        sms
    },
    data() {
        return {
        selectedTabComponent: 'general',
        };
    },
    methods:{
        changeTab(tab) {
            this.selectedTabComponent = tab;
        },
    }
}
</script>
<style lang="">

</style>
