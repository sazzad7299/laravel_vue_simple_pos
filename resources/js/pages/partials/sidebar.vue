<template>
    <div class="col-md-3 left_col menu_fixed">
        <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
                <router-link :to="{ name: 'dashboard' }" class="site_title">
                    <i class="fa bx bx-cart"></i><span class="fw-bolder ms-2  text-capitalize" v-if="companyInfo">{{
                        companyInfo.company_name }}</span>
                </router-link>
            </div>
            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu mt-5">
                <div class="menu_section">
                    <ul class="nav side-menu">
                        <li :class="$route.name === 'dashboard' ? 'active' : ''"><router-link :to="{ name: 'dashboard' }"
                                class="menu-link">
                                <i class="fa bx bx-home"></i>
                                {{ $t('trans.dashboard') }}
                            </router-link></li>
                            <li :class="$route.name === 'sale.create' ? 'active' : ''"><router-link :to="{ name: 'sale.create' }"
                                class="menu-link">
                                <i class="fa bx bx-star"></i>
                                {{ $t('trans.pos') }}
                            </router-link></li>
                            <li :class="$route.name === 'sale.index' ? 'active' : ''"><router-link :to="{ name: 'sale.index' }"
                                class="menu-link">
                                <i class='fa bx bxs-shopping-bags'></i>
                                {{ $t('trans.sale') }} {{ $t('trans.list') }}
                            </router-link></li>
                        <li
                            v-if="hasPermission('user') || hasPermission('user.index') || hasPermission('user.create') || hasPermission('user.edit') || hasPermission('user.delete')">
                            <a><i class="fa bx bx-user"></i> {{ $t('trans.Users') }} <span
                                    class="bx bx-chevron-down float-right"></span></a>
                            <ul class="nav child_menu">
                                <li v-if="hasPermission('user.create')" class="menu-item"
                                    :class="$route.name === 'user.create' ? 'current_page' : ''">
                                    <router-link :to="{ name: 'user.create' }" class="menu-link"> <i
                                            class="menu-icon tf-icons bx bx-add-to-queue"></i>{{ $t('trans.User') }} {{
                                                $t('trans.add')
                                            }}</router-link>
                                </li>
                                <li v-if="hasPermission('user.index') || hasPermission('user.edit') || hasPermission('user.delete')"
                                    :class="$route.name === 'user.index' ? 'current-page' : ''">
                                    <router-link :to="{ name: 'user.index' }" class="menu-link"> <i
                                            class="menu-icon tf-icons bx bx-list-ol"></i>{{ $t('trans.User') }} {{
                                                $t('trans.list')
                                            }}</router-link>
                                </li>
                                <li v-if="hasPermission('role.index')" class="menu-item"
                                    :class="$route.name === 'role.index' || $route.name === 'role.crate' || $route.name === 'role.edit' ? 'current_page' : ''">
                                    <router-link :to="{ name: 'role.index' }" class="menu-link">
                                        <i class="menu-icon tf-icons bx bx-check-shield"></i> {{ $t('trans.Role') }}
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <li
                            v-if="hasPermission('product') || hasPermission('product.index') || hasPermission('product.create') || hasPermission('product.edit') || hasPermission('product.delete')">
                            <a><i class="fa bx bxl-product-hunt"></i> {{ $t('trans.products') }} <span
                                    class="bx bx-chevron-down float-right"></span></a>
                            <ul class="nav child_menu">
                                <li v-if="hasPermission('product.create')" class="menu-item"
                                    :class="$route.name === 'product.create' ? 'current_page' : ''">
                                    <router-link :to="{ name: 'product.create' }" class="menu-link"> <i
                                            class="menu-icon tf-icons bx bx-add-to-queue"></i>{{ $t('trans.product') }} {{
                                                $t('trans.add')
                                            }}</router-link>
                                </li>
                                <li v-if="hasPermission('product.index') || hasPermission('product.edit') || hasPermission('product.delete')"
                                    :class="$route.name === 'product.index' ? 'current-page' : ''">
                                    <router-link :to="{ name: 'product.index' }" class="menu-link"> <i
                                            class="menu-icon tf-icons bx bx-list-ol"></i>{{ $t('trans.product') }} {{$t('trans.list')}}</router-link>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <i class="fa bx bxs-cog"></i>
                                {{ $t('trans.Settings') }} <span class="bx bx-chevron-down float-right"></span>
                            </a>
                            <ul class="nav child_menu">
                                <li class="menu-item" :class="$route.name === 'balance.index' ? 'current-page' : ''">
                                    <router-link :to="{ name: 'language.index' }" class="menu-link">
                                        <i class="menu-icon tf-icons bx bx-list-ol"></i>
                                        {{ $t('trans.Languages') }}
                                    </router-link>
                                </li>
                                <li class="menu-item" :class="$route.name === 'appseting.index' ? 'current-page' : ''">
                                    <router-link :to="{ name: 'appseting.index' }" class="menu-link">
                                        <i class="menu-icon tf-icons bx bx-list-ol"></i>
                                        {{ $t('trans.App') }} {{ $t('trans.Setting') }}
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>

            </div>

            <!-- /sidebar menu -->
        </div>
    </div>
</template>
<script>
import { defineComponent } from 'vue';


export default defineComponent({
    name: 'sidebar',
    mounted() {
        const script = document.createElement('script');
        script.src = '/backend/admin1/js/custom.js';
        script.async = true;
        document.body.appendChild(script);

    }
});

</script>
<style scoped>.form-check-input[type=checkbox] {
    border: 1px solid #123 !important;
}</style>
