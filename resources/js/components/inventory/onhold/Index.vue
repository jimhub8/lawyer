<template>
<v-content>
    <v-container fluid fill-height v-show="!loader">
        <v-layout justify-center align-center wrap>
            <v-flex sm12>
                <v-card style="padding: 20px 0;">
                    <el-breadcrumb separator-class="el-icon-arrow-right">
                        <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
                        <el-breadcrumb-item>Products</el-breadcrumb-item>
                        <el-breadcrumb-item>Product History</el-breadcrumb-item>
                    </el-breadcrumb>
                </v-card>
            </v-flex>
            <v-flex sm12>
                <v-card style="padding: 10px 0;">
                    <v-layout row>
                        <v-flex sm1 style="margin-left: 10px;">
                            <v-tooltip right>
                                <v-btn icon slot="activator" class="mx-0" @click="getonHold">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                                <span>Refresh</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex sm3>
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
                    <b-table :data="isEmpty ? [] : onhold.data" :bordered="isBordered" :striped="isStriped" :narrowed="isNarrowed" :hoverable="isHoverable" :loading="isLoading" :focusable="isFocusable" :mobile-cards="hasMobileCards" :paginated="isPaginated" :per-page="perPage" :current-page.sync="currentPage">

                        <template slot-scope="props">
                            <b-table-column field="uro_id" label="URO ID" width="40" numeric style="cursor: pointer">
                                <a @click="openEdit(props.row)">{{ props.row.uro_id }}</a>

                            </b-table-column>
                            <b-table-column field="created_at" label="CREATED DATE" width="40">
                                {{ props.row.created_at }}
                            </b-table-column>
                            <b-table-column field="fulfillment_center" label="FULFILLMENT CENTER">
                                {{ props.row.fulfillment_center }}
                            </b-table-column>

                            <b-table-column field="type" label="TYPE">
                                {{ props.row.type }}
                            </b-table-column>
                            <b-table-column field="tracking" label="TRACKING/BOP">
                                {{ props.row.tracking }}
                            </b-table-column>
                            <b-table-column field="wro" label="WRO">
                                {{ props.row.wro }}
                            </b-table-column>
                            <b-table-column field="pallet" label="BOX/PALLET">
                                {{ props.row.pallet }}
                            </b-table-column>
                            <b-table-column field="label_image" label="LABEL IMAGE">
                                <img :src="props.row.label_image" alt="">
                                <!-- {{ props.row.label_image }} -->
                            </b-table-column>
                            <b-table-column field="item_image" label="ITEM IMAGE">
                                <img :src="props.row.item_image" alt="">
                                <!-- {{ props.row.item_image }} -->
                            </b-table-column>
                            <b-table-column field="reason" label="REASON">
                                {{ props.row.reason }}
                            </b-table-column>
                            <b-table-column field="comment" label="COMMENT">
                                {{ props.row.comment }}
                            </b-table-column>
                            <b-table-column field="linked_on" label="LINKED ON">
                                {{ props.row.linked_on }}
                            </b-table-column>
                            <b-table-column label="Actions">
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="openEdit(props.row)" slot="activator">
                                        <v-icon small color="blue darken-2">edit</v-icon>
                                    </v-btn>
                                    <span>Edit</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="deleteItem(props.row)" slot="activator">
                                        <v-icon small color="pink darken-2">delete</v-icon>
                                    </v-btn>
                                    <span>Delete</span>
                                </v-tooltip>
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
            eventBus.$emit("openShowProduct", data);
        },
        getonHold() {
            this.isLoading
            eventBus.$emit("LoadingEvent");
            this.$store.dispatch("getonHold");
        }
    },
    computed: {
        onhold() {
            return this.$store.getters.onhold;
        },
        isLoading() {
            return this.$store.getters.loading;
        }
    },
    mounted() {
        // this.$store.dispatch('getonHold');
        eventBus.$emit("LoadingEvent");
        this.getonHold();
    },
    created() {
        eventBus.$on("productEvent", data => {
            this.getonHold();
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
