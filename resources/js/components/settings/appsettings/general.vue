<template >
    <div>
        <div class="card">
            <div class="card-body">
                <div class="general-information">
                    <div class="text-left">
                        <h5 class="text-uppercase">{{ $t('trans.company') }} {{ $t('trans.information') }}:</h5>
                        <hr>
                    </div>
                    <form @submit.prevent="updateCompanyInfo" @keydown="allErrors.clear($event.target.name)" class="row g-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ $t('trans.company') }} {{ $t('trans.name') }}</label>
                            <span class="text-danger">*</span><input name="company_name" type="text" class="form-control"
                                v-model="form.company_name">
                                <span v-if="this.allErrors.has('company_name')" class="error text-danger fw-semibold mt-3"
                                v-text="this.allErrors.get('company_name')">
                            </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Address</label>
                            <span class="text-danger">*</span><input name="company_address" type="text" class="form-control"
                                v-model="form.company_address">
                                <span v-if="this.allErrors.has('company_address')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('company_address')">
                                    </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12"><label class="form-label">Admin Email</label><span
                                class="text-danger">*</span>
                            <input name="company_email" type="email" class="form-control" v-model="form.company_email">
                            <span v-if="this.allErrors.has('company_email')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('company_email')">
                                    </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12"><label class="form-label">Contact No.</label>
                            <span class="text-danger">*</span><input name="company_contanct_no" type="text" class="form-control"
                                v-model="form.company_contanct_no">
                                <span v-if="this.allErrors.has('company_contanct_no')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('company_contanct_no')">
                                    </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12"><label class="form-label">Currency symbol</label><span
                                class="text-danger">*</span>
                            <input name="currency_symbol" type="text" class="form-control" v-model="form.currency_symbol">
                            <span v-if="this.allErrors.has('currency_symbol')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('currency_symbol')">
                                    </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12"><label class="form-label">Currency code</label>
                            <span class="text-danger">*</span><input name="currency_code" type="text" class="form-control"
                                v-model="form.currency_code">
                                <span v-if="this.allErrors.has('currency_code')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('currency_code')">
                                    </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Logo</label>
                            <span class="text-danger">*</span>
                            <div class="image-container">
                                <img class="img-preview"
                                    :src="logo ? logo : '/images/blank.jpg'"
                                    alt="Company Logo">
                                    <input type="file" class="form-control" placeholder="Note" name="logo"
                                    @change="onFileChange($event, 'logo')">
                                    <span v-if="this.allErrors.has('logo')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('logo')">
                                    </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Fav icon</label>
                            <span class="text-danger">*</span>
                            <div class="image-container">
                                <img class="img-preview"
                                    :src="icon ? icon : '/images/blank.jpg'"
                                    alt="Company Logo">
                                    <input type="file" class="form-control" placeholder="Note" name="icon"
                                    @change="onFileChange($event,'icon')">
                                    <span v-if="this.allErrors.has('icon')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('icon')">
                                    </span>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center"><button class="btn btn-primary"
                                type="submit">Update</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Errors from "../../../errors/errors";
import { handleErrorResponse } from '../../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../../errors/successHandler.js';
export default {
    data() {
        return {
            allErrors: new Errors(),
            form: {},
            logo:'',
            icon:'',
        }
    },
    methods: {
        fetchData() {
            this.loader(true);
            axios
                .get(`/setting/general-info`)
                .then((response) => {
                    this.loader(false)
                    this.form = response.data.result;
                    if (response.data.result.logo)
                        this.logo = '/' + response.data.result.logo;
                        this.form.logo = null;
                    if (response.data.result.icon)
                        this.icon = '/' + response.data.result.icon;
                        this.form.icon = null;
                    handleSuccessResponse.call(this, response);
                })
                .catch((error) => {
                    this.loader(false)
                    handleErrorResponse.call(this, error)

                });
        },
        updateCompanyInfo() {
            this.loader(true);
            axios
                .put(`/setting/general-info`, { ...this.form })
                .then((response) => {
                    this.loader(false)
                    handleSuccessResponse.call(this, response);
                })
                .catch((error) => {
                    this.loader(false)
                    handleErrorResponse.call(this, error)

                });
        },
        onFileChange(event,type) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                if (type === 'logo') {
                    this.form.logo = event.target.result;
                    this.logo = this.form.logo;
                } else if (type === 'icon') {
                    this.form.icon = event.target.result;
                    this.icon = this.form.icon;
                }
            };
            reader.readAsDataURL(file);
        },
    },
    created() {
        this.fetchData();
    }
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
}
</style>
