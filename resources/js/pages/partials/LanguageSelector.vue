<template>
    <li class="nav-item">
        <select name="language" class="form-control" v-model="lang.lang" @change="changelocale">
        
            <option v-for="option in data" :key="option.id" :value="option.code" v-show="option.status ===1">
        {{ option.name }}
  </option>
         </select>
    </li>
  </template>
  
  <script >

  import { loadLanguageAsync } from "laravel-vue-i18n";
   export default{
    data() {
		return {
			data: [],
            lang:{
                lang: localStorage.getItem('lang') || 'en'
            }
		};
	},
    methods:{
        fetchData() {
			axios
				.get(`/setting/language`)
				.then((response) => {
					this.data = response.data.result;
					if (this.data) {
						this.data = this.data.slice().reverse();
						console.log(this.data)
					}
				})
				.catch((error) => {
					console.error(error);
				});
		},
        changelocale(){
            axios
                .get(`/language/${this.lang.lang}`)
                .then((response) => {
                    localStorage.setItem("lang", this.lang.lang);
                    toastr.success("Update Language");
                    loadLanguageAsync(this.lang.lang);
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
    created() {
		this.fetchData();
	},
   } 
  </script>
  
  <style scoped>
  /* Add any scoped styles if needed */
  </style>
  