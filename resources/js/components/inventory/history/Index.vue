<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center wrap>
            <v-flex sm12>
                <v-card style="padding: 20px 0;">
                    <el-breadcrumb separator-class="el-icon-arrow-right">
                        <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
                        <el-breadcrumb-item>history</el-breadcrumb-item>
                        <el-breadcrumb-item>Product History</el-breadcrumb-item>
                    </el-breadcrumb>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <v-card style="padding: 10px 0;">
                    <v-layout row>
                        <v-flex sm1 style="margin-left: 10px;">
                            <v-tooltip right>
                                <v-btn icon slot="activator" class="mx-0" @click="getProduct">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                                <span>Refresh</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex sm2>
                            <h3 style="margin-left: 30px !important;margin-top: 10px;">Product History</h3>
                        </v-flex>
                        <v-flex sm3>
                            <v-autocomplete v-model="model" :items="items" :loading="isLoading" :search-input.sync="search" chips clearable hide-details hide-selected item-text="name" item-value="symbol" label="Search for a product..." solo>
                                <template v-slot:no-data>
                                    <v-list-tile>
                                        <v-list-tile-title>
                                            Enter product
                                        </v-list-tile-title>
                                    </v-list-tile>
                                </template>
                                <template v-slot:selection="{ item, selected }">
                                    <v-chip :selected="selected" color="blue-grey" class="white--text">
                                        <v-icon left>mdi-coin</v-icon>
                                        <span v-text="item.name"></span>
                                    </v-chip>
                                </template>
                                <template v-slot:item="{ item }">
                                    <v-list-tile-avatar color="indigo" class="headline font-weight-light white--text">
                                        {{ item.name.charAt(0) }}
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title v-text="item.name"></v-list-tile-title>
                                        <v-list-tile-sub-title v-text="item.symbol"></v-list-tile-sub-title>
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                        <v-icon>mdi-coin</v-icon>
                                    </v-list-tile-action>
                                </template>
                            </v-autocomplete>
                        </v-flex>
                        <v-flex sm2 offset-sm1>
                            <el-input placeholder="Please input" v-model="form.start_date" type="date"></el-input>
                        </v-flex>
                        <v-flex sm2>
                            <el-input placeholder="Please input" v-model="form.end_date" type="date"></el-input>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <section style="overflow: scroll;">
                    <b-table :data="isEmpty ? [] : products.data" :bordered="isBordered" :striped="isStriped" :narrowed="isNarrowed" :hoverable="isHoverable" :loading="isLoading" :focusable="isFocusable" :mobile-cards="hasMobileCards" checkable :paginated="isPaginated" :per-page="perPage" :current-page.sync="currentPage" default-sort="id" default-sort-direction="desc">
                        <template slot-scope="props">
                            <b-table-column sortable field="id" label="ID" width="40" numeric style="cursor: pointer">
                                <!-- <a @click="openHistory(props.row)">{{ props.row.id }}</a> -->
                                <!-- <v-btn color="primary" @click="openHistory(props.row)" flat>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <span v-on="on">{{ props.row.id }}</span>
                                        </template>
                                        <span>View product history</span>
                                    </v-tooltip>
                                </v-btn> -->
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn color="primary" @click="openHistory(props.row)" flat dark v-on="on">{{ props.row.id }}</v-btn>
                                    </template>
                                    <span>Click to see product history</span>
                                </v-tooltip>
                            </b-table-column>
                            <b-table-column sortable field="product_name" label="NAME" width="40">
                                {{ props.row.product_name }}
                            </b-table-column>
                            <b-table-column sortable field="sku_no" label="SKU">
                                {{ props.row.sku_no }}
                            </b-table-column>

                            <b-table-column sortable field="onhand" label="ON HAND">
                                {{ props.row.onhand }}
                            </b-table-column>
                            <b-table-column sortable field="platform" label="PLATFORM">
                                {{ props.row.platform }}
                            </b-table-column>
                            <b-table-column sortable field="bar_code" label="BARCODE">
                                {{ props.row.bar_code }}
                            </b-table-column>
                            <b-table-column sortable field="lot_product" label="LOT PRODUCT">
                                {{ props.row.lot }}
                            </b-table-column>
                            <b-table-column sortable field="has_serial" label="HAS SERIAL">
                                {{ props.row.has_serial }}
                            </b-table-column>
                            <b-table-column sortable field="dangerous" label="DANGEROUS GOODS">
                                {{ props.row.dangerous }}
                            </b-table-column>
                            <b-table-column sortable field="created_at" label="CREATED ON" centered>
                                <span class="tag is-info">
                                {{ props.row.created_at }}
                                <!-- {{ props.row.created_at }} -->
                            </span>
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
            // isLoading: false,
            hasMobileCards: true,
            items: [],
            model: null,
            search: null,
            isPaginated: true,
            currentPage: 1,
            perPage: 5
        };
    },
    methods: {
        openCreate() {
            eventBus.$emit("openCreateProduct");
        },
        openHistory(data) {
            console.log(data);
            this.$router.push({
                name: "productHistory",
                params: {
                    id: data.id
                }
            });
        },
        openShow(data) {
            eventBus.$emit("openShowProduct", data);
        },
        getProduct() {
            this.isLoading
            // eventBus.$emit("LoadingEvent");
            this.$store.dispatch("getProducts");
        }
    },
    computed: {
        products() {
            return this.$store.getters.products;
        },
        isLoading() {
            return this.$store.getters.loading;
        }
    },
    mounted() {
        // this.$store.dispatch('getProduct');
        eventBus.$emit("LoadingEvent");
        this.getProduct();
    },
    created() {
        eventBus.$on("productEvent", data => {
            this.getProduct();
        });
    },
    watch: {
        search(val) {
            // Items have already been loaded
            if (this.items.length > 0) return;

            this.isLoading = true;

            // Lazily load input items
            fetch("https://api.coinmarketcap.com/v2/listings/")
                .then(res => res.json())
                .then(res => {
                    this.items = res.data;
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => (this.isLoading = false));
        }
    }
};
</script>

<style scoped>
.el-input--prefix .el-input__inner {
    border-radius: 50px !important;
}
</style>
