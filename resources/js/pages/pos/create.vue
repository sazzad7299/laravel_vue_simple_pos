<template>
    <div @keydown="clearError($event.target.name)" class="full-height">
        <div class="card py-4">
            <div class="row full-height">
                <div class="col-md-6 px-4 border-right-2 border-dark">
                    <div class="row">
                        <div class="col-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" placeholder="Name" v-model="search">
                            <span class="bx bx-text form-control-feedback left" aria-hidden="true"></span>
                            <span class="bx bx-barcode form-control-feedback right" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="card mt-2 border-top-2 border-dark product-list vertical-example">
                        <div class="row item-align-center">
                            <div class="spinner-border spinner-border-lg text-primary" role="status" v-show="Loader.items">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <template v-if="products.data?.length > 0">
                                <div v-for="(product, index) in products.data" :key="index">
                                    <div class="card" @click="addProduct(product)">
                                        <div class="d-flex flex-column align-items-center medicine">
                                            <div class="flex-shrink-0">
                                                <span class="badge  rounded-pill bg-success ms-auto text-light">QTY:{{
                                                    product.unit_value }}</span>
                                                <img :src="image" alt="Credit Card" class="rounded"
                                                    v-if="product.image == null">
                                                <img :src="product.image ? '../' + product.image : '/images/blank.jpg'"
                                                    alt="Credit Card" class="rounded" v-else>
                                            </div>
                                            <span class="d-block">{{ product.name }}</span>
                                            <span class="d-block"> <span v-if="product.discount_amount > 0"> {{
                                                product.selling_price - product.discount_amount }}<del
                                                        class="text-danger ml-2">{{ product.selling_price
                                                        }}</del></span></span>
                                        </div>
                                    </div>
                                    <pagination :data="products" :limit="10" :align="'right'"
                                        @pagination-change-page="getPaginatedproduct($event)" />
                                </div>
                            </template>
                            <template v-else>
                                <div>
                                    <p>No Product available</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 cart-content">
                    <div class="table-responsive vertical-example">
                        <table class="table table-sm text-center cart-list ">
                            <thead class="text-light bg-dark">
                                <tr class="">
                                    <th>Name</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th> <i class="bx bx-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody v-if="saleProducts.length > 0">
                                <tr v-for="(product, index) in saleProducts" :key="index">
                                    <td class="name">{{ product.name }}</td>
                                    <td class="qty fillable px-2"><input v-model="product.quantity" type="number"
                                            @change="calculateFields(product)" min="1"
                                            :class="{ 'bg-red': allErrors.has('saleProducts.' + index + '.quantity') }" />
                                    </td>
                                    <td class="mrp">
                                        <input v-model="product.price" type="number" disabled />
                                    </td>
                                    <td>
                                        <input v-model="product.subtotal" type="number" disabled />
                                    </td>
                                    <td>
                                        <button @click="removeProduct(index)" class="btn btn-danger btn-sm"><i
                                                class="bx bx-minus "></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4" class="mt-5">Recent Cart Is empty</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="footer-content text-dark table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><strong>Subtotal</strong></td>
                                    <td><span class="float-right">{{ sale.subtotal }}</span></td>
                                    <input type="hidden" name="sub_total" v-model="sale.subtotal" />
                                </tr>
                                <tr>
                                    <td><strong>Product Discount</strong></td>
                                    <td><span class="float-right">{{ sale.discount }}</span></td>
                                    <input type="hidden" name="discount" v-model="sale.discount" />
                                </tr>
                                <tr>
                                    <td><strong>Tax</strong></td>
                                    <td><span class="float-right">(+) {{ sale.tax }}</span></td>
                                    <input type="hidden" name="tax" v-model="sale.tax" />
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><span class="float-right">{{ sale.total }}</span></td>
                                    <input type="hidden" name="total" v-model="sale.total" />
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <div class="d-flex">
                                            <button @click="submitForm" class="form-control bg-dark text-light">Place
                                                Order</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";
import Errors from "../../errors/errors";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';

export default {
    data() {
        return {
            allErrors: new Errors(),
            products: {},
            search: '',
            perPage: 1,
            saleProducts: [],
            sale: {
                subtotal: parseFloat(Math.round(0)).toFixed(2),
                discount: parseFloat(Math.round(0)).toFixed(2),
                total: parseFloat(Math.round(0)).toFixed(2),
                tax: parseFloat(Math.round(0)).toFixed(2),
            },
            Loader: {
                items: true
            },
            image: 'images/blank.jpg'
        };
    },
    watch: {
        perPage(perPage) {
            this.getproduct({ page: 1, perPage })
        },
        search: _.debounce(function (search) {
            this.getproduct({ page: 1, search })
        }, 500),
        saleProducts: {
            handler: function () {
                this.calculateFields();
            },
            deep: true
        }
    },
    methods: {
        getPaginatedproduct(page) {
            this.getproduct({ page: page });
        },

        addProduct(newproduct) {
            const existingProduct = this.saleProducts.find((product) => product.id === newproduct.id);
            if (existingProduct) {
                existingProduct.quantity += 1;
                toastr.success("Update Requested product quantity");
            } else {
                const product = {
                    id: newproduct.id,
                    name: newproduct.name,
                    quantity: 1,
                    price: newproduct.selling_price,
                    discount: newproduct.discount_amount,
                    tax: newproduct.vat_amount,
                }
                this.saleProducts.push(product);
            }
        },
        removeProduct(index) {
            this.saleProducts.splice(index, 1);
        },
        calculateFields() {
            let subtotal = 0;
            let discount = 0;
            let tax = 0;
            this.saleProducts.forEach((product) => {
                product.subtotal = (product.price * product.quantity).toFixed(2);
                product.discounttotal = (product.discount * product.quantity).toFixed(2);
                product.total_tax = (product.tax * product.quantity).toFixed(2);
                subtotal += parseFloat(product.subtotal);
                discount += parseFloat(product.discounttotal);
                tax += parseFloat(product.total_tax);
            });

            this.sale.subtotal = subtotal;
            this.sale.discount = discount;
            this.sale.tax = tax;
            this.sale.total = parseFloat(this.sale.subtotal + this.sale.tax - this.sale.discount).toFixed(2);
            this.sale.total = parseFloat(Math.round(this.sale.total)).toFixed(2);
        },
        async submitForm() {
            try {
                const productsData = this.saleProducts.map((product) => {
                    return {
                        product_id: product.id,
                        price: product.price,
                        quantity: product.quantity,
                        subtotal: product.subtotal,
                        discount: product.discount,
                        tax: product.tax,
                    };
                });

                const formData = {
                    saleProducts: productsData,
                    sale: this.sale,
                };

                const response = await axios.post('sale', formData);
                this.saleData = response.data;

                handleSuccessResponse.call(this, response);

                this.saleProducts = [];
                this.sale = {
                    subtotal: parseFloat(Math.round(0)).toFixed(2),
                    discount: parseFloat(Math.round(0)).toFixed(2),
                    total: parseFloat(Math.round(0)).toFixed(2),
                    tax: parseFloat(Math.round(0)).toFixed(2),
                };
            } catch (error) {
                handleErrorResponse.call(this, error);
            }
        },
        getproduct({ page = 1, perPage = this.perPage, search = this.search }) {
            this.Loader.items = true;
            axios.get('/product', {
                params: {
                    page,
                    per_page: perPage,
                    search,
                }
            })
            .then((response) => {
                this.Loader.items = false;
                this.products = response.data.result;
            })
            .catch((error) => {
                this.Loader.items = false;
                toastr.error(error.response.data.message);
            })
        },
        clearError(fieldName) {
            this.allErrors.errors[fieldName] = null;
        },
    },
    created() {
        this.getproduct({ page: 1 });
        const html = $('body');
        const SIDEBAR_MENU = $('#sidebar-menu li.active ul');
        if (html.hasClass('nav-md')) {
            html.removeClass('nav-md');
            html.addClass('nav-sm');
            SIDEBAR_MENU.css("display", "none");
        } else if (html.hasClass('nav-sm')) {
            SIDEBAR_MENU.css("display", "none");
        } else {
            html.addClass('nav-md');
            SIDEBAR_MENU.css("display", "block");
        }

    }
}
</script>

<style scoped>
@import '../../../css/sale.css';

.footer-content {
    position: relative;
    bottom: 0px;
}</style>
