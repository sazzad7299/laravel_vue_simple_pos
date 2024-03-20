<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <div
                    class="col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2">

                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3">
                        <div class="dt-buttons btn-group flex-wrap">
                            <router-link :to="{ name: 'product.create' }">
                                <button class="btn btn-secondary btn-primary" type="button">
                                    <span>

                                        <span class="d-md-inline-block d-none">Create Product</span>
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
                            <th>Sl</th>
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Purchase Price</th>
                            <th>Selling Price</th>
                            <th>Discount</th>
                            <th>Vat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr :class="index % 2 === 0 ? 'odd' : 'even'" v-for="(product, index) in products.data">
                            <td class="fw-semibold">
                                {{ products.from + index }}
                            </td>
                            <td class="fw-semibold">
                                {{ product.sku }}
                            </td>
                            <td class="fw-semibold">
                                {{ product.name }}
                            </td>
                            <td class="fw-semibold">
                                {{ product.unit_value }} {{ product.unit }}
                            </td>
                            <td class="fw-semibold">
                                {{ product.purchase_price }}
                            </td>
                            <td class="fw-semibold">
                                {{ product.selling_price }}
                            </td>
                            <td class="fw-semibold">
                                {{ product.discount }}
                            </td>
                            <td class="fw-semibold">
                                {{ product.vat ?? 0 }}
                            </td>

                        </tr>
                    </tbody>
                </table>
                <div class="row mx-2">
                    <div class="col-sm-12 col-md-6">
                        <div class="fw-semibold" role="status" aria-live="polite">
                            Showing {{ products.from }}
                            to {{ products.to }} of {{ products.total }} entries
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <pagination :data="products" :limit="10" :align="'right'"
                            @pagination-change-page="getPaginatedproduct($event)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import _ from "lodash";
export default {
    name: 'product Index',
    data() {
        return {
            products: {},
            search: '',
            perPage: 10,
            items: [10, 20, 30, 40, 50],
        }
    },
    watch: {
        perPage(perPage) {
            this.getproduct({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getproduct({ page: 1, search })
        }, 500),
    },
    methods: {
        getPaginatedproduct(page) {
            this.getproduct({ page: page });
            this.scrollToTop();
        },
        getproduct({ page = 1, perPage = this.perPage, search = this.search }) {
            this.loader(true);
            axios.get('/product', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
                .then((response) => {
                    this.loader(false);
                    this.products = response.data.result;
                })
                .catch((error) => {
                    this.loader(false);
                    toastr.error(error.response.data.message);
                    console.log(error.response.data.message)
                })
        }
    },
    mounted() {
        this.getproduct({ page: 1 });
    }
}
</script>

<style scoped></style>
