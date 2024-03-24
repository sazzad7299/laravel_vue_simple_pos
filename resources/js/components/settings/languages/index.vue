<template>
	<div class="container-xxl flex-grow-1 container-p-y">
		<div class="row justify-content-md-center">
			<div class="col-md-12">
				<CreateModal :onFatch="fetchData" />
				<EditModal :data="this.selectedItem" :onFatch="fetchData" />
				<div class="row">
					<div class="col-lg-12 mx-auto">
						<div class="card">
							<div class="card-header py-3 bg-transparent">
								<div class="d-sm-flex align-items-center">
									<h5 class="mb-2 mb-sm-0 align-items-left">{{ $t('trans.Language') }}</h5>
									<div class="ms-auto align-items-right">
										<button class="btn btn-secondary m-1" @click="showCreateModal()">
											{{ $t('trans.add') }} {{ $t('trans.Language') }}
										</button>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table align-middle table-striped">
										<thead>
											<tr>
												<th>{{ $t('trans.SN') }}</th>
												<th> {{ $t('trans.Name') }}</th>
												<th>{{ $t('trans.Code') }}</th>
												<th>{{ $t('trans.Status') }}</th>
												<th class="d-none">{{ $t('Default') }}</th>
												<th class="text-center">{{ $t('translate') }}</th>
												<th>{{ $t('Action') }}</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="(item, index)  in  data " :key="index">
												<td>
													<span>{{ ++index }}</span>
												</td>
												<td>
													<span>{{ item.name }}</span>
												</td>
												<td>
													<span>{{ item.code }}</span>
												</td>
												<td>
													<div class="form-check form-switch">
														<input class="form-check-input" type="checkbox" role="switch"
															:checked="item.status" @change=updateStatus(item.code)>
													</div>
												</td>
												<td class="d-none">
													<div class="form-check form-switch">
														<input class="form-check-input" type="checkbox" role="switch"
															:checked="item.default" @change=updateDefaultStatus(item.code)>
													</div>
												</td>
												<td class="text-center">
													<router-link class="btn btn-info btn-sm" v-if="item.code != 'en'"
														:to="{ name: 'language.translate', params: { code: item.code } }">
														<span class="material-symbols-outlined google-icon" role="button"><i
																class="bx bx-pencil"></i></span>
													</router-link>
												</td>
												<td>
													<div class="d-flex align-items-center gap-3 fs-6"
														v-if="item.code != 'en'">
														<button class="d-none btn btn-sm btn-warning" @click="showEditModal(item)">
															<span class="material-symbols-outlined google-icon"
																role="button"><i class="bx bx-pencil"></i></span>
														</button>
														<button type="button" class="btn btn-sm btn-danger hide-arrow"
															@click="softDeleteUnit(item)">
															<i class="bx bx-trash"></i>
														</button>
													</div>
												</td>
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
		</div>
	</div>
</template>

<script>
import CreateModal from "./create-modal.vue";
import EditModal from "./edit-modal.vue";
import Errors from "../../../errors/errors";
import { handleErrorResponse } from '../../../errors/errorHandler.js';
import { handleSuccessResponse } from '../../../errors/successHandler.js';
export default {
	components: { CreateModal, EditModal },
	data() {
		return {
			allErrors: new Errors(),
			data: {},
			selectedItem: {},
			codeToDelete: "",
		};
	},
	methods: {
		updateDefaultStatus(code) {
			let form = { code: code };
			axios
				.put(`/setting/language/update-default-status`, form)
				.then((response) => {
					this.language.setDefault(code);
					this.fetchData();
					handleSuccessResponse.call(this, response);
				})
				.catch((error) => {
					handleErrorResponse.call(this, error);
				});
		},
		updateStatus(code) {
			let form = { code: code };
			axios
				.put(`/setting/language/update-status`, form)
				.then((response) => {
					this.fetchData();
					handleSuccessResponse.call(this, response);
				})
				.catch((error) => {
					handleErrorResponse.call(this, error);
				});
		},
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
		showCreateModal() {
			$("#createModal").modal("show");
		},
		showEditModal(item) {
			this.selectedItem = item;
			$("#editModal").modal("show");
		},
		softDeleteUnit(item) {
            const confirmed = window.confirm(
                "Are you sure you want to delete this Payment Method?"
            );
            if (confirmed) {
                this.loader(true);
                axios
                    .delete(`/setting/language/${item.code}`)
                    .then((response) => {
                        handleSuccessResponse.call(this, response);
                        this.fetchData();
                    })
                    .catch((error) => {
                        this.loader(false);
                        handleErrorResponse.call(this, error);
                    });
            }
        },
	},
	created() {
		this.fetchData();
	},
};
</script>
