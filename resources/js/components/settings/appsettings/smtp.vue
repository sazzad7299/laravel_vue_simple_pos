<template >
    <div>
        <div class="card">
            <div class="card-body">
                <div class="general-information">
                    <div class="text-left">
                        <h5 class="text-uppercase">{{ $t('trans.smtp') }} {{ $t('trans.setup') }} :</h5>
                        <hr>
                    </div>
                    <form @submit.prevent="updateSMTP" @keydown="allErrors.clear($event.target.name)" class="row g-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Host</label>
                            <span class="text-danger">*</span><input name="MAIL_HOST" type="text" class="form-control"
                                v-model="form.MAIL_HOST">
                                <span v-if="this.allErrors.has('MAIL_HOST')" class="error text-danger fw-semibold mt-3"
                                v-text="this.allErrors.get('MAIL_HOST')"></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Port</label>
                            <span class="text-danger">*</span><input name="MAIL_PORT" type="number" class="form-control"
                                v-model="form.MAIL_PORT">
                                <span v-if="this.allErrors.has('MAIL_PORT')" class="error text-danger fw-semibold mt-3"
                                v-text="this.allErrors.get('MAIL_PORT')"></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12"><label class="form-label">Username</label><span
                                class="text-danger">*</span>
                            <input name="MAIL_USERNAME" type="text" class="form-control" v-model="form.MAIL_USERNAME">
                            <span v-if="this.allErrors.has('MAIL_USERNAME')" class="error text-danger fw-semibold mt-3"
                            v-text="this.allErrors.get('MAIL_USERNAME')"></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12"><label class="form-label">Password</label>
                            <span class="text-danger">*</span><input name="MAIL_PASSWORD" type="text" class="form-control"
                                v-model="form.MAIL_PASSWORD">
                                <span v-if="this.allErrors.has('MAIL_PASSWORD')" class="error text-danger fw-semibold mt-3"
                                v-text="this.allErrors.get('MAIL_PASSWORD')"></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">From Name</label>
                            <span class="text-danger">*</span>
                            <input name="MAIL_FROM_Name" type="text" class="form-control" v-model="form.MAIL_FROM_NAME">
                            <span v-if="this.allErrors.has('MAIL_FROM_NAME')" class="error text-danger fw-semibold mt-3"
                            v-text="this.allErrors.get('MAIL_FROM_NAME')"></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">From Address</label>
                            <span class="text-danger">*</span><input name="MAIL_FROM_ADDRESS" type="text"
                                class="form-control" v-model="form.MAIL_FROM_ADDRESS">
                                <span v-if="this.allErrors.has('MAIL_FROM_ADDRESS')" class="error text-danger fw-semibold mt-3"
                                v-text="this.allErrors.get('MAIL_FROM_ADDRESS')"></span>
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
        }
    },
    methods: {
        fetchData() {
            this.loader(true);
            axios
                .get(`/setting/smtp`)
                .then((response) => {
                    this.loader(false)
                    this.form = response.data.result;
                    handleSuccessResponse.call(this, response);
                })
                .catch((error) => {
                    this.loader(false)
                    handleErrorResponse.call(this, error)

                });
        },
        updateSMTP() {
            this.loader(true);
            axios
                .put(`/setting/smtp`, { ...this.form })
                .then((response) => {
                    this.loader(false)
                    handleSuccessResponse.call(this, response);
                })
                .catch((error) => {
                    this.loader(false)
                    handleErrorResponse.call(this, error)

                });
        }
    },
    created() {
        this.fetchData();
    }
}
</script>
<style ></style>
