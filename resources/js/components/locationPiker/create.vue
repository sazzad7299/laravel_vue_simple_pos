<template lang="">
<div class="mb-3 col-md-3">
        <label class="form-label" for="basic-default-name">Country</label>
        <v-select :options="countries"
                    :label="'name'"
                    name="country"
                    :placeholder="'Select Country'"
                    :reduce="country => country.id"
                    :loading="Loader.country"
                    v-model="user.country_id"
                    @update:modelValue="this.allErrors.clear(`country_id`)">
        </v-select>
        <span v-if="this.allErrors.has('country_id')"
                class="error text-danger fw-semibold mt-3"
                v-text="this.allErrors.get('country_id')">
        </span>
    </div>
    <div class="mb-3 col-md-3">
        <label class="form-label" for="basic-default-name">State</label>
        <v-select :options="divisions"
                    :label="'name'"
                    name="division_id"
                    :placeholder="'Select State'"
                    :reduce="division => division.id"
                    :loading="Loader.division"
                    v-model="user.division_id"
                    @update:modelValue="this.allErrors.clear('division_id')">
        </v-select>
        <span v-if="this.allErrors.has('division_id')"
                class="error text-danger fw-semibold mt-3"
                v-text="this.allErrors.get('division_id')">
        </span>
    </div>
    <div class="mb-3 col-md-3">
        <label class="form-label" for="basic-default-name">City</label>
        <v-select :options="districts"
                    :label="'name'"
                    name="district_id"
                    :placeholder="'Select City'"
                    :reduce="district => district.id"
                    :loading="Loader.district"
                    v-model="user.district_id"
                    @update:modelValue="this.allErrors.clear('district_id')">
        </v-select>
        <span v-if="this.allErrors.has('district_id')"
                class="error text-danger fw-semibold mt-3"
                v-text="this.allErrors.get('district_id')">
        </span>
    </div>
    <div class="mb-3 col-md-3">
        <label class="form-label" for="basic-default-name">Street Address</label>
        <input type="text" class="form-control" placeholder="Street Address" name="street_address"
                autocomplete="off" v-model="user.street_address">
        <span v-if="this.allErrors.has('street_address')"
                class="error text-danger fw-semibold mt-3"
                v-text="this.allErrors.get('street_address')">
        </span>
    </div>
    <div class="mb-3 col-md-3">
        <label class="form-label" for="basic-default-name">Zip Code </label>
        <input type="number" class="form-control" placeholder="Zip Code" name="zip_code"
                autocomplete="off" v-model="user.zip_code">
        <span v-if="this.allErrors.has('zip_code')"
                class="error text-danger fw-semibold mt-3"
                v-text="this.allErrors.get('zip_code')">
        </span>
    </div>
    
</template>
<script>

export default {
  props: {
    user: Object, // Pass the "form" object as a prop
    allErrors: Object, // Pass the "form" object as a prop
    colDef: String,
  },
  data() {
    return {
        countries: [],
        divisions: [],
        districts: [],
        Loader: {
            country: false,
            division: false,
            district: false,
        },
      colSize: "col-6",
    };
  },
  watch: {
        'user.country_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.user.division_id = '';
                this.user.district_id = '';
                this.user.upazilas_id = '';
                this.user.union_id = '';
                return;
            }
            this.user.division_id = '';
            this.user.district_id = '';
            this.user.upazilas_id = '';
            this.user.union_id = '';
            this.getDivisionList();
        },
        'user.division_id': function (newVal, oldVal) {
            if (newVal === null) {
                this.user.district_id = '';
                this.user.upazilas_id = '';
                this.user.union_id = '';
                return;
            }
            this.user.district_id = '';
            this.user.upazilas_id = '';
            this.user.union_id = '';
            this.getDistrictList();
        },
    },
  methods:
  {
    getCountry() {
            this.Loader.country = true;
            axios.get('country')
                .then(response => {
                    this.Loader.country = false;
                    this.countries = response.data.result;
                })
                .catch(error => {
                    toastr.error(error.message);
                })
        },
        getDivisionList() {
            this.Loader.division = true;
            axios.get('country-wise-division/' + this.user.country_id)
                .then(response => {
                    setTimeout(() => {
                        this.Loader.division = false;
                    }, 500);

                    this.divisions = response.data.result;
                })
                .catch(error => {
                    handleErrorResponse.call(this, error);
                })
        },
        getDistrictList() {
            this.Loader.district = true;
            axios.get('division-wise-district/' + this.user.division_id)
                .then(response => {
                    setTimeout(() => {
                        this.Loader.district = false;
                    }, 500);
                    this.districts = response.data.result;
                })
                .catch(error => {
                    toastr.error(error.message);
                })
        }
  },
  mounted() {
    this.getCountry();
  },
};
</script>
<style lang="">

</style>