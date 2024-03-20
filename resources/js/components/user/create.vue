<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold">Add User <router-link :to="{name: 'user.index'}" class="btn btn-sm btn-primary float-right">
                        User List
                    </router-link></h5>
                    <div class="card-body">
                        <form @submit.prevent="createUser" @keydown="allErrors.clear($event.target.name)">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Name<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="name"
                                           autocomplete="off" v-model="user.name">
                                    <span v-if="this.allErrors.has('name')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('name')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Email<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Email" name="email"
                                           autocomplete="off" v-model="user.email">
                                    <span v-if="this.allErrors.has('email')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('email')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Phone<span
                                        class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone"
                                           autocomplete="off" v-model="user.phone">
                                    <span v-if="this.allErrors.has('phone')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('phone')">
                                    </span>
                                </div>
                                <LocationPiker :user="user" :allErrors="allErrors" colDef="col-lg-6"></LocationPiker>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Role Assign <span
                                        class="text-danger">*</span> </label>
                                    <v-select :options="roles"
                                            :reduce="role=>role.id"
                                              :label="'name'"
                                              name="role_id"
                                              :placeholder="'Select Role'"
                                              :loading="Loader.role"
                                              v-model="user.role_id"
                                              @update:modelValue="this.allErrors.clear('role_id')">
                                    </v-select>
                                    <span v-if="this.allErrors.has('role_id')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('role_id')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Password<span
                                        class="text-danger">*</span> </label>
                                    <input type="password" class="form-control" placeholder="Enter Password"
                                           name="password"
                                           autocomplete="off" v-model="user.password">
                                    <span v-if="this.allErrors.has('password')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('password')">
                                    </span>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label" for="basic-default-name">Confirm Password<span
                                        class="text-danger">*</span> </label>
                                    <input type="password" class="form-control" placeholder="Confirm Password"
                                           name="password_confirmation"
                                           autocomplete="off" v-model="user.password_confirmation">
                                    <span v-if="this.allErrors.has('password_confirmation')"
                                          class="error text-danger fw-semibold mt-3"
                                          v-text="this.allErrors.get('password_confirmation')">
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
                                <div class="mb-3 col-md-12 d-flex justify-content-center">
                                    <div class="image-container">
                                        <img class="img-preview" :src="user.image ? user.image : '/images/blank.jpg'"
                                             alt="Card image cap">
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
import LocationPiker from '../locationPiker/create.vue'

export default {
    name: "Create user",
    components:{LocationPiker},
    data() {
        return {
            allErrors: new Errors(),
            user: {
                name: '',
                phone: '',
                email: '',
                password: '',
                password_confirmation: '',
                country_id: '',
                division_id: '',
                district_id: '',
                role_id: '',
                zip_code: '',
                street_address: '',
                image: '',
            },
            pharmacies: [],
            roles: [],
            Loader: {
                pharmacy: false,
                role: false,
            },
            isPharmacy: localStorage.getItem('PharmacyUser')
        }
    },
    methods: {
        createUser() {
            this.loader(true);
            axios.post('user', {
                ...this.user
            })
                .then(response => {
                    if (response.status === 201) {
                        this.loader(false);
                        handleSuccessResponse.call(this, response);
                        this.$router.push({name: 'user.index'});
                    }
                })
                .catch(error => {
                    this.loader(false);
                    handleErrorResponse.call(this, error);
                })
        },
        getRole() {
            this.Loader.role = true;
            axios.get('/rbac/get-roles')
                .then(response => {
                    setTimeout(() => {
                        this.Loader.role = false;
                    }, 500);
                    this.roles = response.data.result;
                })
                .catch(error => {
                    toastr.error(error.message);
                })
        },

        onFileChange(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                this.user.image = event.target.result;
            };
            reader.readAsDataURL(file);
        },
    },
    mounted() {
        this.getRole();
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
