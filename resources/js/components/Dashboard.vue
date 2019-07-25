<template>
<v-content style="margin-top: 50px !important;">
    <v-container fluid fill-height>
        <v-layout justify-center align-center>
            <v-flex sm12>
                <el-row :gutter="12" style="width: 100%">
                    <el-col :span="4">
                        <el-card shadow="hover">
                            <div class="text-center">
                                <p style="font-size: 36px;color: #1093de;">0</p>
                                <small>QTY</small>
                                <!-- <v-icon dark right style="padding: 0;font-size: 39px !important;">check_circle</v-icon><span>Hover</span> -->
                                <h5>TO BE PACKED</h5>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="4">
                        <el-card shadow="hover">
                            <div class="text-center">
                                <p style="font-size: 36px;color: #db3f26;">0</p>
                                <small>PKGS</small>
                                <!-- <v-icon dark right style="padding: 0;font-size: 39px !important;">check_circle</v-icon><span>Hover</span> -->
                                <h5>TO BE SHIPPED</h5>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="4">
                        <el-card shadow="hover">
                            <div class="text-center">
                                <p style="font-size: 36px;color: #388a10;">0</p>
                                <small>PKGS</small>
                                <!-- <v-icon dark right style="padding: 0;font-size: 39px !important;">check_circle</v-icon><span>Hover</span> -->
                                <h5>TO BE DELIVERED</h5>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="4">
                        <el-card shadow="hover">
                            <div class="text-center">
                                <p style="font-size: 36px;color: #f4a204;">0</p>
                                <small>QTY</small>
                                <!-- <v-icon dark right style="padding: 0;font-size: 39px !important;">check_circle</v-icon><span>Hover</span> -->
                                <h5>TO BE INVOICED</h5>
                            </div>
                        </el-card>
                    </el-col>
                    <v-divider vertical></v-divider>
                    <el-col :span="6">
                        <el-card shadow="hover">
                            <div>
                                <h4>QUANTITY ON HAND <span style="float:right;border-left: 1px solid;padding-left: 10px;">{{ onhand }}</span> </h4>
                            </div>
                        </el-card>
                        <el-card shadow="hover">
                            <div>
                                <h4>QUANTITY TO BE RECEIVED <span style="float:right;border-left: 1px solid;padding-left: 10px;">{{ tobe_received }}</span> </h4>
                            </div>
                        </el-card>
                    </el-col>
                </el-row>
                <v-layout wrap>
                    <v-card style="padding: 20px; width: 100%;">
                        <v-flex sm12>
                            <v-layout wrap>
                                <v-flex sm12>
                                    <el-row :gutter="12" style="width: 100%">
                                        <el-col :span="12">
                                            <el-card shadow="hover">
                                                <h2>PRODUCT DETAILS</h2>
                                                <v-divider></v-divider>
                                                <ul class="list-group">
                                                    <v-layout wrap>
                                                        <v-flex sm7>
                                                            <div>
                                                                <li class="list-group-item row " style="color: #db3f26">
                                                                    <label class="col-md-8 col-lg-8"><b>Low Stock Items</b></label><small style="float: right;">{{ low_stoke }}</small>
                                                                </li>
                                                                <li class="list-group-item row">
                                                                    <label class="col-md-5 col-lg-5"><b>All Item Groups</b></label><small style="float: right;">0</small>
                                                                </li>
                                                                <li class="list-group-item row">
                                                                    <label class="col-md-5 col-lg-5"><b>All Items </b></label>
                                                                    <small style="float: right;">{{ product_count }}</small>
                                                                </li>
                                                            </div>
                                                        </v-flex>
                                                        <v-flex sm5>
                                                            <pie-chart :data="active_chart" style="height: 200px;"></pie-chart>
                                                        </v-flex>
                                                    </v-layout>
                                                </ul>
                                            </el-card>
                                        </el-col>
                                        <el-col :span="12">
                                            <el-card shadow="hover">
                                                <h2>TOP SELLING ITEMS</h2>
                                                <v-divider></v-divider>
                                                <ul class="list-group">
                                                    <v-layout wrap>
                                                        <v-flex sm12>
                                                            <div>
                                                                <p>No items were invoiced in this time frame</p>
                                                            </div>
                                                        </v-flex>
                                                    </v-layout>
                                                </ul>
                                            </el-card>
                                        </el-col>
                                    </el-row>
                                </v-flex>

                                <v-flex sm12 style="margin-top: 30px;">
                                    <el-row :gutter="12" style="width: 100%">
                                        <el-col :span="24">
                                            <el-card shadow="hover">
                                                <h2>SALES ORDER SUMMARY (IN KES)</h2>
                                                <v-divider></v-divider>
                                                  <line-chart :data="chartsummary" :download="true"></line-chart>
                                            </el-card>
                                        </el-col>
                                    </el-row>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-card>
                </v-layout>
                <!-- <v-btn @click="getBranchCount" flat color="primary">Count</v-btn> -->
            </v-flex>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
export default {
    props: ["user"],
    data() {
        return {
            chartData: [["Jan", 4], ["Feb", 2], ["Mar", 10], ["Apr", 5], ["May", 3], ["June", 12], ["July", 7], ["Aug", 3], ["Sept", 13], ["Oct", 23], ["Nov", 3], ["Dec", 22]]
        }
    },
    methods: {
        getLowstock() {
            this.$store.dispatch('getLowstock')
        }
    },
    computed: {
        low_stoke() {
            return this.$store.getters.low_stoke
        },
        tobe_received() {
            return this.$store.getters.tobe_received
        },
        onhand() {
            return this.$store.getters.onhand
        },
        product_count() {
            return this.$store.getters.product_count
        },
        chartsummary() {
            return this.$store.getters.chartsummary
        },
        active_chart() {
            return this.$store.getters.active_chart
        },
    },
    mounted() {
        this.$store.dispatch('product_count')
        this.$store.dispatch('tobe_received')
        this.$store.dispatch('getOnhand')
        this.$store.dispatch('getLowstock')

        // Charts
        this.$store.dispatch('getChartSummary')
        this.$store.dispatch('getActiveProducts')
    },
}
</script>

<style scoped>
.justify-center {
    margin-top: -100px !important;
}

.card-stats {
    margin-top: -10px;
    padding: 20px 0;
}

/* .statistics {
    background: #f0f0f0 !important;
} */

.progress-Ship {
    margin-top: 100px !important;
}

.v-icon {
    font-size: 64px !important;
}

.v-icon {
    box-shadow: 0 9px 30px -6px rgba(255, 54, 54, .5);
    padding: 5px;
    border-radius: 50%;
}

.info-title {
    margin-top: 20px;
}
</style>
