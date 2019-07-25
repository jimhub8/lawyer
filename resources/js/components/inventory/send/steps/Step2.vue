<template>
<div>
    <p>This process will help you get your inventory from where you have it to our warehouses and generate a Warehouse Receiving Order.</p>
    <v-divider></v-divider>
    <v-layout wrap>
        <v-flex sm6>
            <h2>Select the items you want to send below <b>or</b></h2>
        </v-flex>
        <v-flex sm4>
            <v-btn flat color="primary">Upload Via Excel</v-btn>
        </v-flex>
    </v-layout>
    <v-layout wrap>
        <v-flex sm3>
            <section>
                <!-- <p class="content"><b>Selected:</b> {{ selected }}</p> -->
                <b-field>
                    <b-autocomplete :data="data" placeholder="Enter a product" field="product_name" :loading="isFetching" @typing="getAsyncData" @select="option => selected = option" ref="autocomplete">
                        <template slot="header">
                            <a @click="showAddProducts">
                                <span> Add new... </span>
                            </a>
                        </template>
                        <template slot-scope="props">
                            <div class="media">
                                <div class="media-left">
                                    <img width="32" :src="props.option.item_image">
                                </div>
                                    <div class="media-content">
                                        {{ props.option.product_name }}
                                        <br>
                                        <!-- <small>
                                        Released at {{ props.option.release_date }},
                                        rated <b>{{ props.option.vote_average }}</b>
                                    </small> -->
                                    </div>
                                </div>
                        </template>
                    </b-autocomplete>
                </b-field>
            </section>
        </v-flex>
        <v-flex sm3>
            <el-input placeholder="Quantity" v-model="selected.qty" type="number" v-if="selected != null"></el-input>
        </v-flex>
        <v-flex sm3>
            <v-btn color="primary" flat @click="pushProduct">Add Product</v-btn>
        </v-flex>
    </v-layout>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">PRODUCT NAME</th>
                <th scope="col">SKU ID</th>
                <th scope="col">LOT NO</th>
                <th scope="col">EXPIRY DATE</th>
                <th scope="col">QUANTITY</th>
                <th scope="col">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="selectedProduct in form.selectedProducts" :key="selectedProduct.id" v-if="form.selectedProducts.length > 0">
                <th scope="row">{{ selectedProduct.id }}</th>
                <td>{{ selectedProduct.product_name }}</td>
                <td>{{ selectedProduct.sku_no }}</td>
                <td>{{ selectedProduct.lot_no }}</td>
                <td>{{ selectedProduct.exp_date }}</td>
                <td>{{ selectedProduct.qty }}</td>
                <td>
                    <v-tooltip bottom>
                        <v-btn icon class="mx-0" @click="removeProduct(selectedProduct.id)" slot="activator">
                            <v-icon color="pink darken-2" small>delete</v-icon>
                        </v-btn>
                        <span>Remove</span>
                    </v-tooltip>
                </td>
            </tr>
            <tr v-else>
                <p class="text-center">No data</p>
            </tr>
        </tbody>
    </table>
    <Create></Create>
</div>
</template>

<script>
import debounce from 'lodash/debounce'
import Create from '../../../products/Create'
export default {
    components: {
        Create
    },
    props: ['form'],
    data() {
        return {
            isLoading: false,
            data: [],
            selected: [],
            isFetching: false,
            tableData: [{
                id: '2016-05-03',
                product_name: 'Tom',
                sku_no: 'No. 189, Grove St, Los Angeles',
                lot_no: '312232',
                expiry_date: '2019-05-10',
                quantity: '5'
            }, {
                id: '2016-05-02',
                product_name: 'Tom',
                sku_no: 'No. 189, Grove St, Los Angeles',
                lot_no: '1223223',
                expiry_date: '2019-05-10',
                quantity: '30'
            }, {
                id: '2016-05-04',
                product_name: 'Tom',
                sku_no: 'No. 189, Grove St, Los Angeles',
                lot_no: '323134',
                expiry_date: '2019-05-10',
                quantity: '20'
            }, {
                id: '2016-05-01',
                product_name: 'Tom',
                sku_no: 'No. 189, Grove St, Los Angeles',
                lot_no: '656633',
                expiry_date: '2019-05-10',
                quantity: '4'
            }],
            list: [],
            loading: false,
        }
    },
    methods: {
        tableRowClassName({
            row,
            rowIndex
        }) {
            if (rowIndex === 1) {
                return 'warning-row';
            } else if (rowIndex === 3) {
                return 'success-row';
            }
            return '';
        },
        handleDelete() {
            alert('delete')
        },
        pushProduct() {
            this.form.selectedProducts.push(this.selected)
        },
        getAsyncData: debounce(function (name) {
            if (!name.length) {
                // this.data = []
                return
            }
            this.form.search = name
            this.isFetching = true
            axios.post('filterproducts', this.form).then((response) => {
                // eventBus.$emit("stopLoadingEvent");
                // context.commit('updateClientList', response.data)
                // context.commit('loading', false)
                this.isFetching = false
                this.data = response.data
            }).catch((error) => {

            })
        }, 500),
        showAddProducts() {
            eventBus.$emit('openCreateProduct')
        },
        removeProduct(id) {
            const index = this.form.selectedProducts.indexOf(id)
            this.form.selectedProducts.splice(index, 1)
        }
    },
    mounted() {

    },
    watch: {
        search(val) {
            console.log(val);
            this.form.search = val
            // Items have already been loaded
            // if (this.search) {

            // }
            // if (this.products.length > 0) return

            this.isLoading = true

            axios.post('filterproducts', this.form).then((response) => {
                // eventBus.$emit("stopLoadingEvent");
                // context.commit('updateProductsList', response.data)
                // context.commit('loading', false)
                this.isLoading = false
                this.data = response.data
            }).catch((error) => {
                this.isLoading = false

            })
            // Lazily load input items
            // fetch('https://api.coinmarketcap.com/v2/listings/')
            //     .then(res => res.json())
            //     .then(res => {
            //     })
            //     .catch(err => {
            //         console.log(err)
            //     })
            //     .finally(() => (this.isLoading = false))

            // this.$store.dispatch('filterProducts')
        }
    },
    computed: {
        product() {
            return this.$store.getters.products
        }
    },
}
</script>

<style scoped>
.el-table .warning-row {
    background: oldlace;
}

.el-table .success-row {
    background: #f0f9eb;
}
</style>
