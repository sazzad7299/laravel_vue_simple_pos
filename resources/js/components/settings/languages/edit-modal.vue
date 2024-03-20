<template>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ $t('trans.Language') }} {{ $t('trans.Edit') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="row g-3" @keydown="allErrors.clear($event.target.name)" @submit.prevent="submitForm">
                    <div class="modal-body">
                        <div class="col-12 mb-2">
                            <label class="form-label">{{ $t('trans.Language') }} {{ $t('trans.Name') }}</label> <span
                                class="text-danger">*</span>
                            <input name="name" class="form-control" v-model="form.name" type="text" />
                            <span v-if="this.allErrors.has('name')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('name')">
                            </span>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label">{{ $t('trans.Language') }} {{ $t('trans.Code') }}</label> <span
                                class="text-danger">*</span>
                            <select name="code" class="form-control" v-model="form.code">
                                <option :value="form.code">{{ form.code }}</option>
                            </select>
                            <span v-if="this.allErrors.has('code')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('code')">
                            </span>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label"> {{ $t('trans.Direction') }}</label>
                            <select name="direction" class="form-control" v-model="form.direction">
                                <option value="ltr">LTR</option>
                                <option value="rtr">RTR</option>
                            </select>
                            <span v-if="this.allErrors.has('direction')" class="error text-danger text-bold ms-2 mt-2"
                                v-text="this.allErrors.get('direction')">
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $t('trans.Cancel')
                        }}</button>
                        <button class="btn btn-primary" type="submit"> {{ $t('trans.Update') }} </button>
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
        data: Object,
    },
    data() {
        return {
            allErrors: new Errors(),
            form: {
                name: "",
                code: ""
            },
        };
    },
    watch: {
        data: {
            immediate: true,
            handler(newVal) {
                this.form = { ...newVal };
            }
        }
    },
    methods: {
        submitForm() {
            axios
                .put(`/language/${this.form.id}`, this.form)
                .then((response) => {
                    $("#editModal").modal("hide");
                    this.onFatch();
                    handleSuccessResponse.call(this, response);
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
    },
};
</script>

