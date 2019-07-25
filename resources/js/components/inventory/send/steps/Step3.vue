<template>
<div>
    <v-layout wrap>
        <v-flex sm12>
            <p>We need to know a little about your shipment to know how we should organize the packing slips we’ll generate for you.</p>
            <v-divider></v-divider>
            <v-layout wrap>
                <v-flex sm4>
                    <h6>How big will your shipment be?</h6>
                    <v-radio-group v-model="form.delivery_type">
                        <v-radio label="Standard Delivery" value="standard_delivery"></v-radio>
                        <v-radio label="Less Than Truckload (LTL)" value="track load"></v-radio>
                    </v-radio-group>
                </v-flex>
                <v-flex sm4>
                    <h6>Do you want us to generate shipping label(s) for you?</h6>
                    <v-radio-group v-model="form.shipping_label">
                        <v-radio label="I’ll do it myself" value="dont_generate"></v-radio>
                        <v-radio v-if="form.delivery_type === 'standard_delivery'" label="I want Speedball to generate shipping labels for me" value="generate"></v-radio>
                    </v-radio-group>
                    <div v-if="form.shipping_label == 'generate' && form.delivery_type === 'standard_delivery'">
                        <v-card style="padding: 10px;">
                            <v-text-field v-model="company.company_name" label="Company Name"></v-text-field>
                            <v-text-field v-model="company.address" label="Address"></v-text-field>
                            <v-text-field v-model="company.city" label="City"></v-text-field>
                            <v-text-field v-model="company.country" label="Country"></v-text-field>
                            <v-btn flat color="success" :loading="loading" :disabled="loading" @click="addAddress">Add address</v-btn>
                        </v-card>
                    </div>
                    <div>
                        <p>When should we expect to receive this shipment?</p>
                        <p>We only need a rough estimate</p>
                        <!-- <el-input placeholder="Please input" v-model="form.delivery_date" type="date"></el-input> -->
                        <el-date-picker v-model="form.delivery_date" type="date" placeholder="Pick a day" :picker-options="pickerOptions">
                        </el-date-picker>
                    </div>
                </v-flex>
                <v-flex sm4>
                    <h6>How is your shipment packaged?</h6>
                    <el-select v-model="form.shipment_package" clearable placeholder="Select">
                        <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                        </el-option>
                    </el-select>
                    <p v-if="form.shipment_package === 'Multiple sku'">
                        How many boxes you will sending:
                        <span><el-input placeholder="Quantity" v-model="form.no_of_boxes" type="number"></el-input></span>
                    </p>
                    <p>You can only send up to 10 boxes where the SKUs are mixed</p>
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</div>
</template>

<script>
export default {
    props: ['form'],
    data() {
        return {
            options: [{
                value: 'Multiple sku',
                label: 'Multiple sku'
            }, {
                value: 'Single Sku',
                label: 'Single Sku'
            }],
            input: '',
            loading: false,
            company: {},
            pickerOptions: {
                disabledDate(time) {
                    return time.getTime() < Date.now() - 3600 * 1000 * 24
                },
                shortcuts: [{
                    text: 'Today',
                    onClick(picker) {
                        picker.$emit('pick', new Date());
                    }
                }, {
                    text: 'Tomorrow',
                    onClick(picker) {
                        const date = new Date();
                        date.setTime(date.getTime() + 3600 * 1000 * 24);
                        picker.$emit('pick', date);
                    }
                }, {
                    text: 'Next week',
                    onClick(picker) {
                        const date = new Date();
                        date.setTime(date.getTime() + 3600 * 1000 * 24 * 7);
                        picker.$emit('pick', date);
                    }
                }]
            }
        }
    },
    methods: {
        addAddress() {
            // this.loading = true
            this.form.shipping_address.push(this.$data.company)
            // axios.post('/shippinglabel', this.$data.company)
            //     .then((response) => {
            //         this.loading = false
            //         this.form.shipping_address = response.data.id
            //         // console.log(response);
            //         // context.commit('getProducts', response.data)
            //     }).catch((error) => {
            //         // console.log(error.response);
            //         this.loading = false

            //     })
        }
    },
}
</script>
