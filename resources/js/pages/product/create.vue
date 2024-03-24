<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Add Product <router-link :to="{name: 'product.index'}" class="btn btn-sm btn-primary float-right">
                        Product List
                    </router-link></h5>
                    <div class="card-body">
                        <form @submit.prevent="createproduct" @keydown="allErrors.clear($event.target.name)">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Name<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                           autocomplete="off" v-model="product.name">
                                    <span v-if="this.allErrors.has('name')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">SKU<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="sku" name="sku"
                                           autocomplete="off" v-model="product.sku">
                                    <span v-if="this.allErrors.has('sku')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('sku')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Unit (kg,litter,pieces)<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="unit" name="unit"
                                           autocomplete="off" v-model="product.unit">
                                    <span v-if="this.allErrors.has('unit')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('unit')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Unit Value<span
                                        class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="unit value" name="unit_value"
                                           autocomplete="off" v-model="product.unit_value">
                                    <span v-if="this.allErrors.has('unit_value')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('unit_value')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Purchase Price<span
                                        class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="Purchase Price" name="purchase_price"
                                           autocomplete="off" v-model="product.purchase_price">
                                    <span v-if="this.allErrors.has('purchase_price')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('purchase_price')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Sale Price<span
                                        class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="Sale Price" name="selling_price"
                                           autocomplete="off" v-model="product.selling_price">
                                    <span v-if="this.allErrors.has('selling_price')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('selling_price')">
                                    </span>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Discount (%)<span
                                        class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="Discount" name="discount"
                                           autocomplete="off" v-model="product.discount">
                                    <span v-if="this.allErrors.has('discount')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('discount')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Tax(%)<span
                                        class="text-danger">*</span> </label>
                                    <input type="number" class="form-control" placeholder="tax" name="tax"
                                           autocomplete="off" v-model="product.tax">
                                    <span v-if="this.allErrors.has('tax')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('tax')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Image<span
                                        class="text-danger">*</span> </label>
                                    <input type="file" class="form-control" placeholder="Note" name="image"
                                           @change="onFileChange($event)">
                                    <span v-if="this.allErrors.has('image')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('image')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">IS Active<span
                                        class="text-danger">*</span> </label>
                                    <input type="checkbox" class="form-control" v-model="product.status">
                                    <span v-if="this.allErrors.has('image')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('image')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-12 d-flex justify-content-center">
                                    <div class="image-container">
                                        <img class="img-preview" :src="product.image ? product.image : '/images/blank.jpg'"
                                             :alt="'Card cap'">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="d-grid gap-2 col-lg-1 mx-auto">
                                    <button class="btn btn-primary" type="submit">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Errors from "../../errors/errors";
import { handleErrorResponse } from '../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../errors/successHandler.js';

export default {
    name: "Create product",
    data() {
        return {
            allErrors: new Errors(),
            product: {
                name: '',
                sku: '',
                unit: '',
                unit_value: '',
                sale_price: '',
                purchase_price: '',
                discount: '',
                tax: '',
                image: '',
                status: true
            },
        }
    },
    methods: {
        createproduct() {
            this.loader(true);
            axios.post('product', {
                ...this.product
            })
                .then(response => {
                    handleSuccessResponse.call(this, response);
                    this.$router.push({name: 'product.index'});
                })
                .catch(error => {
                    this.loader(false);
                    handleErrorResponse.call(this, error);
                })
        },
        onFileChange(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                this.product.image = event.target.result;
            };
            reader.readAsDataURL(file);
        },
    },
}

</script>
<style scoped>
.image-container {
    display: flex;
    align-items: center;
    flex-direction: column;
    gap: 10px;
}

.img-preview {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 2px solid #ccc;
    border-radius: 50%;
}

</style>
