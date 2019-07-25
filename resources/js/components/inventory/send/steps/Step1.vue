<template>
<div>
    <v-layout wrap>
        <v-flex sm12>
            <p>This process will help you get your inventory from where you have it to our warehouses and generate a Warehouse Receiving Order.</p>
            <v-divider></v-divider>
            <v-layout wrap>
                <v-flex sm6>
                    <v-layout row wrap>
                        <v-flex sm11 offset-sm1>
                            <h2>Which Speedball warehouse will you ship to?</h2>
                            <el-select v-model="form.warehouse" clearable filterable placeholder="Select a warehouse">
                                <el-option v-for="item in warehouse" :key="item.id" :label="item.name" :value="item.id"></el-option>
                            </el-select>
                            <h5>Don’t know where to send your inventory? Choose the warehouse closest to you or you r customers.</h5>
                        </v-flex>
                        <v-flex sm11 offset-sm1>
                            <label for="" style="color: #000;">Client</label>
                            <b-field>
                                <b-autocomplete :data="data" placeholder="Start typing to find or add a customer" field="display_name" :loading="loading" @typing="getAsyncData" @select="option => selected = option" ref="autocomplete">
                                    <template slot="header">
                                        <a @click="addClient">
                                                <span> Add new... </span>
                                            </a>
                                    </template>
                                    <template slot-scope="props">
                                        <div class="media">
                                            <!-- <div class="media-left">
                                        <img width="32" :src="props.option.item_image">
                                    </div> -->
                                            <div class="media-content" @click="select_client(props.option)">
                                                {{ props.option.display_name }}
                                            </div>
                                        </div>
                                    </template>
                                </b-autocomplete>
                            </b-field>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <v-flex sm5 offset-sm1>
                    <h2>Speedball courier services</h2>
                    <address>4779 Hanoverville Road, Suite 200</address>
                    <address>Bethlehem, PA- 18020 </address>
                    <p>Phone<b> (844) 474-4726 </b></p>
                    <p>Email: <a href="mailto:info@speedballcourier.com" target="_blank"><b>info@speedballcourier.com</b></a></p>
                </v-flex>
            </v-layout>
        </v-flex>
        <myClient></myClient>
    </v-layout>
</div>
</template>

<script>
import myClient from '../../../select/client/Create'
export default {
    components: {
        myClient,
    },
    props: ['form'],
    data() {
        return {
            value: '',
            loading: false,
            data: [],

        }
    },
    methods: {
        getWarehouses() {
            this.$store.dispatch('getWarehouses')
        },

        getAsyncData(name) {
            this.loading = true
            if (name.length < 3) {
                this.data = []
                this.loading = false
                return
            }
            this.form.search = name
            axios.get(`searchClient/${name}`).then((response) => {
                this.loading = false
                this.data = response.data
            }).catch((error) => {
                this.loading = false
            })
        },
        addClient() {
            eventBus.$emit('openCreateBox')
        },
        select_client(data) {
            // alert('test')
            // console.log(data);
            this.form.client_id = data.id

        }
    },
    computed: {
        warehouse() {
            return this.$store.getters.warehouse
        },
        isLoading() {
            return this.$store.getters.loading
        },
    },
    mounted() {
        this.getWarehouses()
    },
}
</script>
