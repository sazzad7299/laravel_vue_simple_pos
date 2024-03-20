<template>
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ $t('New') }} {{ $t('Language') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row g-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm">
                    <div class="modal-body">
                        <div class="col-12 mb-2">
                            <label class="form-label">{{ $t('Language') }} {{ $t('Name') }}</label> <span
                                class="text-danger">*</span>
                            <input name="name" class="form-control" v-model="form.name" type="text" />
                            <span v-if="this.allErrors.has('name')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('name')">
                            </span>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label">{{ $t('Language') }} {{ $t('Code') }}</label> <span
                                class="text-danger">*</span>
                            <v-select :options="codeList" :label="'title'" :reduce="option => option"
                                                        name="model_type" :placeholder="$t('Select Code')"
                                                        v-model="form.code"></v-select>
                            <span v-if="this.allErrors.has('code')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('code')">
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $t('Cancel')
                        }}</button>
                        <button class="btn btn-primary" type="submit">{{ $t('Add') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Errors from "../../../errors/errors";
import { handleErrorResponse } from '../../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../../errors/successHandler.js';
export default {
    props: {
        onFatch: Function,
    },
    data() {
        return {
            allErrors: new Errors(),
            form: {
                name: "",
                code: ""
            },
            codeList: []
        };
    },
    methods: {
        fatchCode() {
            axios
                .get(`/setting/language/all-codes`)
                .then((response) => {
                    this.codeList = response.data.result;
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
        submitForm() {
            axios
                .post(`/setting/language`, this.form)
                .then((response) => {
                    $("#createModal").modal("hide");
                    this.onFatch();
                    eventBus.$on('languageAdded');
                    handleSuccessResponse.call(this, response);
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
    },
    created() {
        this.fatchCode();
    }
};
</script>

