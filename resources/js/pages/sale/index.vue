<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <div
                    class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2">

                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3">
                        <div class="dt-buttons btn-group flex-wrap">
                            <router-link :to="{ name: 'sale.create' }">
                                <button class="btn btn-secondary btn-primary" type="button">
                                    <span>

                                        <span class="d-md-inline-block d-none">{{ $t('trans.pos')  }}</span>
                                        <i class="bx bx-plus me-md-1"></i>
                                    </span>
                                </button>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div
                    class="col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-2">
                    <label>
                        <select v-model.number="perPage" class="form-control">
                            <option :value="item" v-for="(item, index) in items" :key="index">{{
                                item
                            }}
                            </option>
                        </select>
                    </label>
                    <div class="dataTables_filter">
                        <label>
                            <input type="search" class="form-control" placeholder="Search" v-model="search"
                                aria-controls="DataTables_Table_0">
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                        <tr class="headings">
                            <th>Date</th>
                            <th>Subtotal</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Total</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(sale, index) in sales.data">
                            <td class="fw-semibold">
                                {{ sales.from + index }}
                            </td>
                            <td class="fw-semibold">
                                {{ sale.subtotal }}
                            </td>
                            <td class="fw-semibold">
                                {{ sale.discount }}
                            </td>
                            <td class="fw-semibold">
                                {{ sale.tax }}
                            </td>
                            <td class="fw-semibold">
                                {{ sale.total }}
                            </td>
                            <td>
                                <router-link :to="{ name: 'sale.view', params: { id: sale.id } }">
                                    <button type="button" class="btn btn-sm btn-primary hide-arrow">
                                        <i class='bx bxs-bullseye'></i>
                                    </button>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mx-2">
                    <div class="col-sm-12 col-md-6">
                        <div class="fw-semibold" role="status" aria-live="polite">
                            Showing {{ sales.from }}
                            to {{ sales.to }} of {{ sales.total }} entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <pagination :data="sales" :limit="10" :align="'right'"
                            @pagination-change-page="getPaginatedsale($event)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import _ from "lodash";
import { collect } from "collect.js";

export default {
    name: 'sale Index',
    data() {
        return {
            sales: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.getsale({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getsale({ page: 1, search })
        }, 500),
    },
    methods: {
        collect,
        getPaginatedsale(page) {
            this.getsale({ page: page });
            this.scrollToTop();
        },
        getsale({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/sale', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.sales = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                    console.log(error.response.data.message)
                })
        }
    },
    mounted() {
        this.getsale({ page: 1 });
    }
}
</script>

<style scoped></style>
