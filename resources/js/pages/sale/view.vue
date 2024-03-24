<template lang="">
    <div>
        <div class="card">
            <div class="card-header">
                <h2>Sale Details</h2>
            </div>

          <div class="card-body">
            <div class="table-responsive text-nowrap px-md-3"  v-if="sale?.result?.sale_details.length >0">
                <table class="table table-sm text-center">
                    <thead>
                        <tr>
                            <th>#{{ $t('trans.SL') }}</th>
                            <th >{{ $t('trans.SKU') }}</th>
                            <th>{{ $t('trans.Name') }}</th>
                            <th>{{ $t('trans.Price') }}</th>
                            <th>{{ $t('trans.Quantity') }}</th>
                            <th >{{ $t('trans.Subtotal') }}</th>
                            <th>{{ $t('trans.Dis') }}</th>
                            <th>{{ $t('trans.Tax') }}</th>
                            <th>{{ $t('trans.Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in sale.result.sale_details" :key="index">
                            <th scope="row">{{ index + 1 }}</th>
                            <td class="hide">
                                {{ product.product.sku }}
                            </td>
                            <td>{{ product.product.name }}</td>
                            <td>{{ product.price }}</td>
                            <td>{{ product.quantity }}</td>
                            <td >{{ product.subtotal }}</td>
                            <td >{{ product.discount *product.quantity }}</td>
                            <td >{{ product.tax *product.quantity }}</td>
                            <td >{{ (product.tax*product.quantity) + product.subtotal - (product.discount*product.quantity)  }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
                <div class="float-right">
                    <table class="table estimate-acount-table text-right calculate_final_amount">
                        <tbody>
                            <tr>
                                <th>{{ $t('trans.Subtotal') }}</th>
                                <td>:</td>
                                <td>{{ sale.result.subtotal }}</td>
                            </tr>
                            <tr>
                                <th>{{ $t('trans.Discount') }}</th>
                                <td>:</td>
                                <td>{{ sale.result.discount }}</td>
                            </tr>
                            <tr>
                                <th>{{ $t('trans.Tax') }}</th>
                                <td>:</td>
                                <td>{{ sale.result.tax }}</td>
                            </tr>
                            <tr>
                                <th>{{ $t('trans.Total') }}</th>
                                <td>:</td>
                                <td>{{ sale.result.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
          </div>
        </div>
    </div>
</template>
<script>
import { handleErrorResponse } from "../../errors/errorHandler.js";
export default {
    data() {
        return {
            sale: {
                result: {
                    sale_details: [],
                }
            },
        };
    },
    methods:{
        getSale() {
            axios
                .get(`sale/${this.$route.params.id}`)
                .then((response) => {
                    this.sale = response.data;
                })
                .catch((error) => {
                    handleErrorResponse.call(this, error);
                });
        },
    },
    created(){
        this.getSale();
    }
}
</script>
<style lang="">

</style>
