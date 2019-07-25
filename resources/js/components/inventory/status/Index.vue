<template>
<v-content>
    <v-container fluid fill-height v-show="!loader">
        <v-layout justify-center align-center wrap>
            <v-flex sm12>
                <v-card style="padding: 20px 0;">
                    <el-breadcrumb separator-class="el-icon-arrow-right">
                        <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
                        <el-breadcrumb-item>Products</el-breadcrumb-item>
                    </el-breadcrumb>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <v-card style="padding: 10px 0;">
                    <v-layout row>
                        <v-flex sm1 style="margin-left: 10px;">
                            <v-tooltip right>
                                <v-btn icon slot="activator" class="mx-0" @click="getProducts">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                                <span>Refresh</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex sm3>
                            <h3 style="margin-left: 30px !important;margin-top: 10px;">Inventory Status</h3>
                        </v-flex>
                        <v-flex sm3>
                            <el-input placeholder="Search all inventory..." v-model="form.search">
                                <i slot="prefix" class="el-input__icon el-icon-search"></i>
                            </el-input>
                        </v-flex>
                        <v-flex sm1 offset-sm2 style="margin-top: -4px">
                            <v-btn flat color="primary">Export to Excel</v-btn>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <section style="overflow: scroll;">
                    <b-table :data="isEmpty ? [] : products.data" :bordered="isBordered" :striped="isStriped" :narrowed="isNarrowed" :hoverable="isHoverable" :loading="isLoading" :focusable="isFocusable" :mobile-cards="hasMobileCards" :paginated="isPaginated" :per-page="perPage" :current-page.sync="currentPage">

                        <template slot-scope="props">
                            <b-table-column field="id" label="ID" width="40" numeric style="cursor: pointer">
                                <a @click="openEdit(props.row)">{{ props.row.id }}</a>

                            </b-table-column>
                            <b-table-column field="product_name" label="PRODUCT NAME" width="40">
                                {{ props.row.product_name }}
                            </b-table-column>
                            <b-table-column field="sku_no" label="STORE SKU">
                                {{ props.row.sku_no }}
                            </b-table-column>

                            <b-table-column field="awaiting_stoke" label="AWAITING RESTOKE">
                                {{ props.row.awaiting_stoke }}
                            </b-table-column>
                            <b-table-column field="onhand" label="ON HAND">
                                {{ props.row.onhand }}
                            </b-table-column>
                            <b-table-column field="onhand" label="COMMITED">
                                {{ props.row.onhand }}
                            </b-table-column>
                            <b-table-column field="onhand" label="INTERNAL TRANSIT">
                                {{ props.row.onhand }}
                            </b-table-column>
                            <b-table-column field="back_ordered" label="BACK ORDERED">
                                {{ props.row.back_ordered }}
                            </b-table-column>
                            <b-table-column field="balanced_inventory" label="BALANCED INVENTORY">
                                {{ props.row.onhand }}
                            </b-table-column>
                            <b-table-column field="fulfillable_inventory" label="FULFILLABLE INVENTORY">
                                {{ props.row.fulfillable_inventory }}
                            </b-table-column>
                            <b-table-column field="external_transit" label="EXTERNAL TRANSIT">
                                {{ props.row.external_transit }}
                            </b-table-column>
                            <b-table-column field="external_warehouse" label="EXTERNAL WAREHOUSE">
                                <!-- {{ props.row.external_warehouse }} -->
                                0
                            </b-table-column>
                        </template>
                        <template slot="empty">
                            <section class="section">
                                <div class="content has-text-grey has-text-centered">
                                    <p>
                                        <b-icon icon="emoticon-sad" size="is-large">
                                        </b-icon>
                                    </p>
                                    <p>Nothing here.</p>
                                </div>
                            </section>
                        </template>
                    </b-table>
                </section>
            </v-flex>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            form: {},
            loader: false,
            isEmpty: false,
            isBordered: true,
            isStriped: true,
            isNarrowed: false,
            isHoverable: true,
            isFocusable: true,
            hasMobileCards: true,
            isPaginated: true,
            currentPage: 1,
            perPage: 5
        }
    },
    methods: {
        openCreate() {
            eventBus.$emit('openCreateProduct')
        },

        openEdit(data) {
            // router.push({ name: 'editProducts', params: { id: data.id } })
            this.$router.push({
                name: "editProducts",
                params: {
                    id: data.id
                }
            });
            // eventBus.$emit('openEditProduct', data)
        },

        openShow(data) {
            eventBus.$emit('openShowProduct', data)
        },
        getProducts() {
            this.$store.dispatch('getProducts');

        }
    },
    computed: {
        products() {
            return this.$store.getters.products
        },
        isLoading() {
            return this.$store.getters.loading
        },
    },
    mounted() {
        // this.$store.dispatch('getProducts');
        this.getProducts();
    },
    created() {
        eventBus.$on('productEvent', data => {
            this.getProducts();
        })
    },
}
</script>

<style scoped>
.el-input--prefix .el-input__inner {
    border-radius: 50px !important;
}
</style>
