<template >
    <div>
        <div class="card">
            <div class="card-body">
                <div class="general-information">
                    <div class="d-flex align-items-center justify-content-between text-center">
                        <h5 class="text-uppercase">{{ $t('trans.sms') }} {{ $t('trans.setup') }} :</h5>
                        <div class="col-md-4">
                            <v-select
                            v-model="sms_getway"
                            :options="selectOptions"
                            label="name"
                            :reduce="option => option.value"
                            ></v-select>
                        </div>
                    </div>
                    <hr>
                    <form @submit.prevent="UpdateSMSSEND" @keydown="allErrors.clear($event.target.name)" class="row g-3">

                        <!-- Start RELEANS information -->
                        <div class="col-lg-6 col-md-6 col-sm-12" v-show="sms_getway=='RELEANS'">
                            <label class="form-label">RELEANS_API_KEY</label>
                            <span class="text-danger">*</span><input name="RELEANS_API_KEY" type="text" class="form-control"
                                v-model="form.RELEANS_API_KEY">
                                <span v-if="this.allErrors.has('RELEANS_API_KEY')" class="error text-danger fw-semibold mt-3"
                                v-text="this.allErrors.get('RELEANS_API_KEY')">
                            </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12" v-show="sms_getway=='RELEANS'">
                            <label class="form-label">RELEANS_API_FROM</label>
                            <span class="text-danger">*</span><input name="RELEANS_API_FROM" type="text" class="form-control"
                                v-model="form.RELEANS_API_FROM">
                                <span v-if="this.allErrors.has('RELEANS_API_FROM')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('RELEANS_API_FROM')">
                                    </span>
                        </div>
                        <!-- END RELEANS information -->
                        <!-- START 2FACTORS  information -->
                        <div class="col-lg-6 col-md-6 col-sm-12" v-show="sms_getway=='2FACTOR'">
                            <label class="form-label">TWOFACTORS_API_KEY</label>
                            <span class="text-danger">*</span><input name="TWOFACTORS_API_KEY" type="text" class="form-control"
                                v-model="form.TWOFACTORS_API_KEY">
                                <span v-if="this.allErrors.has('TWOFACTORS_API_KEY')" class="error text-danger fw-semibold mt-3"
                                v-text="this.allErrors.get('TWOFACTORS_API_KEY')">
                            </span>
                        </div>
                         <!-- START MSG91  information -->
                        <div class="col-lg-6 col-md-6 col-sm-12" v-show="sms_getway=='MSG91'">
                            <label class="form-label">MSG91_TEMPLATE_ID</label>
                            <span class="text-danger">*</span><input name="MSG91_TEMPLATE_ID" type="text" class="form-control"
                                v-model="form.MSG91_TEMPLATE_ID">
                                <span v-if="this.allErrors.has('MSG91_TEMPLATE_ID')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('MSG91_TEMPLATE_ID')">
                                    </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12" v-show="sms_getway=='MSG91'">
                            <label class="form-label">MSG91_AUTH_KEY</label>
                            <span class="text-danger">*</span><input name="MSG91_AUTH_KEY" type="text" class="form-control"
                                v-model="form.MSG91_AUTH_KEY">
                                <span v-if="this.allErrors.has('MSG91_AUTH_KEY')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('MSG91_AUTH_KEY')">
                                    </span>
                        </div>
                        <!-- END TWILIO  information -->
                        <div class="col-lg-6 col-md-6 col-sm-12" v-show="sms_getway=='TWILIO'">
                            <label class="form-label">TWILIO_SID</label>
                            <span class="text-danger">*</span><input name="TWILIO_SID" type="text" class="form-control"
                                v-model="form.TWILIO_SID">
                                <span v-if="this.allErrors.has('TWILIO_SID')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('TWILIO_SID')">
                                    </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12" v-show="sms_getway=='TWILIO'">
                            <label class="form-label">TWILIO_SERVICE_SID</label>
                            <span class="text-danger">*</span><input name="TWILIO_SERVICE_SID" type="text" class="form-control"
                                v-model="form.TWILIO_SERVICE_SID">
                                <span v-if="this.allErrors.has('TWILIO_SERVICE_SID')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('TWILIO_SERVICE_SID')">
                                    </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12" v-show="sms_getway=='TWILIO'">
                            <label class="form-label">TWILIO_TOKEN</label>
                            <span class="text-danger">*</span><input name="TWILIO_TOKEN" type="text" class="form-control"
                                v-model="form.TWILIO_TOKEN">
                                <span v-if="this.allErrors.has('TWILIO_TOKEN')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('TWILIO_TOKEN')">
                                    </span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12" v-show="sms_getway=='TWILIO'">
                            <label class="form-label">TWILIO_FROM</label>
                            <span class="text-danger">*</span><input name="TWILIO_FROM" type="text" class="form-control"
                                v-model="form.TWILIO_FROM">
                                <span v-if="this.allErrors.has('TWILIO_FROM')" class="error text-danger fw-semibold mt-3"
                                        v-text="this.allErrors.get('TWILIO_FROM')">
                                    </span>
                        </div>
                        <!-- END TWILIO  information -->

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
            sms_getway: "TWILIO",
            selectOptions: [
                { name: '2FACTOR', value: '2FACTOR' },
                { name: 'MSG91', value: 'MSG91' },
                { name: 'RELEANS', value: 'RELEANS' },
                { name: 'TWILIO', value: 'TWILIO' },
            ],
        }
    },
    watch:{
        'sms_getway':function(newVal,oldVal){
            if (!newVal) {
            this.sms_getway = oldVal;
            } else {
                this.sms_getway = newVal;
                console.log(newVal);
            }
        }
    },
    methods: {
        fetchData() {
            this.loader(true);
            axios
                .get(`/setting/sms`)
                .then((response) => {
                    this.loader(false)
                    this.form = response.data.result;
                    this.sms_getway = this.form.SMS_METHOD;
                    this.form.SMS_METHOD = null;
                    handleSuccessResponse.call(this, response);
                })
                .catch((error) => {
                    this.loader(false)
                    handleErrorResponse.call(this, error)

                });
        },
        UpdateSMSSEND() {
            this.loader(true);
            this.form.SMS_METHOD = this.sms_getway;
            axios
                .put(`/setting/sms`, { ...this.form })
                .then((response) => {
                    this.loader(false)
                    handleSuccessResponse.call(this, response);
                })
                .catch((error) => {
                    this.loader(false)
                    handleErrorResponse.call(this, error)

                });
        },
    },
    created() {
        this.fetchData();
    }
}
</script>
<style scoped>
</style>
