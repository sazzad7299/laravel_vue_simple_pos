<template>
	<div class="container-xxl flex-grow-1 container-p-y">
		<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Languages /</span>
		</h4>
		<div class="row justify-content-md-center">
			<div class="col-lg-12 mx-auto">
				<div class="card">
					<div class="card-header py-3 bg-transparent">
						<div class="d-sm-flex align-items-center">
							<h5 class="mb-2 mb-sm-0 align-items-left">{{ $t('Language') }} {{ $t('Content') }}
								{{ $t('Table') }} </h5>
							<div class="ms-auto align-items-right">
								<router-link :to="{ name: 'language.index' }" class="btn btn-secondary m-1">
									{{ $t('Back') }}
								</router-link>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table align-middle table-striped">
								<thead>
									<tr>
										<th>{{ $t('SL') }}</th>
										<th>{{ $t('Key') }}</th>
										<th>{{ $t('Value') }}</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(value, key, index) in data" :key="key">
										<td>{{ ++index }}</td>
										<td><span>{{ key }}</span></td>
										<td><input type="text" class="form-control" v-model="data[key]" /></td>
									</tr>
									<tr>
										<td><button class="btn btn-success" @click="updateAllLangs">Update All</button></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end row-->
	</div>
</template>

<script>
import { handleErrorResponse } from '../../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../../errors/successHandler.js';
export default {
	data() {
		return {
			data: {},
			code: this.$route.params.code,
		};
	},

	methods: {
		removeKey(key) {
			let form = { key: key };
			axios
				.put(`/setting/language/translate-key-remove/${this.code}`, form)
				.then((response) => {
					this.toast.success(response.data);
				})
				.catch((error) => {

				});
		},
		updateLang(key, value) {
			this.loader(true);
			let form = { key: key, value: value };
			axios
				.put(`/setting/language/translate-submit/${this.code}`, form)
				.then((response) => {
					this.loader(false);

					handleSuccessResponse.call(this, response);
				})
				.catch((error) => {
					this.loader(false);
					handleErrorResponse.call(this, error);
				});
		},
		fetchData() {
			axios
				.get(`/setting/language/translate/${this.code}`)
				.then((response) => {
					this.data = response.data.result;
				})
				.catch((error) => {
					console.error(error);
				});
		},
		updateAllLangs() {
			this.loader(true);
			axios.put(`setting/language/translate-submit/${this.code}`, { translations: this.data })
				.then(response => {
					this.loader(false);
					handleSuccessResponse.call(this, response);
				})
				.catch(error => {
					this.loader(false);
					handleErrorResponse.call(this, error);
				});
		},
	},
	created() {
		this.fetchData();
	},
};
</script>
