<template>
<div>
    <v-app id="inspire">
        <el-button type="primary" v-loading.fullscreen.lock="fullscreenLoading">
            As a directive
        </el-button>
        <v-navigation-drawer right temporary v-model="right" fixed></v-navigation-drawer>
        <v-navigation-drawer fixed :color="color" :clipped="$vuetify.breakpoint.lgAndUp" app v-model="drawer">
            <v-list dense id="navigation">
                <v-img :aspect-ratio="16/9" src="/storage/landS.jpg">
                    <v-layout pa-2 column fill-height class="lightbox white--text">
                        <v-spacer></v-spacer>
                        <v-flex shrink>
                            <div class="subheading">{{ user.name }}</div>
                            <div class="body-1">{{ user.email }}</div>
                        </v-flex>
                    </v-layout>
                </v-img>
                <template>
                    <v-card>
                        <router-link to="/" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">dashboard</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Dashboard</div>
                            </div>
                        </router-link>
                        <!-- <router-link to="/users" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">account_circle</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Users</div>
                            </div>
                        </router-link> -->

                        <v-list-group prepend-icon="settings">
                            <v-list-tile slot="activator">
                                <v-list-tile-title>App Settings</v-list-tile-title>
                            </v-list-tile>
                            <router-link to="/boxes" class="v-list__tile theme--light" style="text-decoration: none">
                                <v-list-tile-action>
                                    <v-icon>map</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Boxes</v-list-tile-title>
                            </router-link>
                            <router-link to="/type" class="v-list__tile theme--light" style="text-decoration: none">
                                <v-list-tile-action>
                                    <v-icon>dialpad</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Product Type</v-list-tile-title>
                            </router-link>
                            <router-link to="/classification" class="v-list__tile theme--light" style="text-decoration: none">
                                <v-list-tile-action>
                                    <v-icon>dialpad</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Classification</v-list-tile-title>
                            </router-link>
                        </v-list-group>

                        <router-link to="/clients" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">people_outline</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Clients</div>
                            </div>
                        </router-link>

                        <router-link to="/salesorders" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">shopping_cart</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Orders</div>
                            </div>
                        </router-link>
                        <v-list-group prepend-icon="list">
                            <v-list-tile slot="activator">
                                <v-list-tile-title>Inventory</v-list-tile-title>
                            </v-list-tile>
                            <router-link to="/products" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action">
                                    <i aria-hidden="true" class="icon material-icons">dashboard</i>
                                </div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">Products</div>
                                </div>
                            </router-link>
                            <router-link to="/sendInventory" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action">
                                    <i aria-hidden="true" class="icon material-icons">widgets</i>
                                </div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">Send Inventory</div>
                                </div>
                            </router-link>
                            <router-link to="/warehouse" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action">
                                    <i aria-hidden="true" class="icon material-icons">gavel</i>
                                </div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">Warehouse Receiving Orders</div>
                                </div>
                            </router-link>
                            <router-link to="/inventorystatus" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action">
                                    <i aria-hidden="true" class="icon material-icons">event</i>
                                </div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">Inventory Status</div>
                                </div>
                            </router-link>
                            <router-link to="/history" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action">
                                    <i aria-hidden="true" class="icon material-icons">history</i>
                                </div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">Product History</div>
                                </div>
                            </router-link>
                            <router-link to="/transfer" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action">
                                    <i aria-hidden="true" class="icon material-icons">transfer_within_a_station</i>
                                </div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">Inventory Transfer</div>
                                </div>
                            </router-link>
                            <router-link to="/onhold" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action">
                                    <i aria-hidden="true" class="icon material-icons">receipt</i>
                                </div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">On hold Receiving</div>
                                </div>
                            </router-link>
                        </v-list-group>
                    </v-card>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar dark app :color="color" :clipped-left="$vuetify.breakpoint.lgAndUp" fixed>
            <v-toolbar-title style="width: 600px" class="ml-0 pl-3">
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>MFT fulfillment
                <img
            src="/storage/logo.png"
            alt
            style="width: 100px; height: 60px;"
          >
        </v-toolbar-title>
                <v-spacer></v-spacer>
                <!-- <v-divider vertical></v-divider> -->
                <!-- <Notifications :user="user"></Notifications> -->
                <!-- <v-divider vertical></v-divider> -->
                <!-- <chattyNoty :user="user"></chattyNoty> -->
                <!-- <v-icon @click.stop="right = !right" style="cursor: pointer">apps</v-icon> -->
                <!-- <form action="/logout" method="post">
                    <v-btn flat color="white" type="submit">Logout</v-btn>
                </form> -->
                <Logout :user="user"></Logout>

        </v-toolbar>
    </v-app>

    <v-snackbar :timeout="timeout" bottom="bottom" :color="Snackcolor" left="left" v-model="snackbar">
        {{ message }}
        <v-icon dark right>check_circle</v-icon>
    </v-snackbar>
</div>
</template>

<script>
// import Notifications from "../notification/Notification";
// // import AddShipment from "../shipments/AddShipment";
// import { vueTopprogress } from "vue-top-progress";
import Logout from "./Logout";
// import chattyNoty from '../notification/chattyNoty'
export default {
    components: {
        // Notifications,
        // AddShipment,
        // vueTopprogress,
        Logout
        //  chattyNoty
    },
    props: ["user"],
    data() {
        return {
            role: "",
            Snackcolor: '',
            color: "rgb(129, 129, 129)",
            loading: false,
            dialog: false,
            drawer: true,
            drawerRight: false,
            right: null,
            mode: "",
            company: {},
            AllBranches: [],
            Allcustomers: [],
            AllDrivers: [],
            snackbar: false,
            timeout: 5000,
            message: "Success",
            fullscreenLoading: false,
        };
    },
    methods: {
        openShipment() {
            this.dialog = true;
            this.getBranch();
            this.getCustomer();
            this.getDrivers();
        },

        getCustomer() {
            axios
                .get("/getCustomer")
                .then(response => {
                    this.Allcustomers = response.data;
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        getDrivers() {
            axios
                .get("/getDrivers")
                .then(response => {
                    this.AllDrivers = response.data;
                })
                .catch(error => {
                    // console.log(error);
                    this.errors = error.response.data.errors;
                });
        },
        getBranch() {
            axios
                .get("/getBranchEger")
                .then(response => {
                    this.AllBranches = response.data;
                })
                .catch(error => {
                    // console.log(error);
                    this.errors = error.response.data.errors;
                });
        },
        close() {
            this.dialog = false;
        },

        showalert(data) {
            this.message = data;
            this.Snackcolor = "indigo";
            this.snackbar = true;
        },
        openFullScreen() {
            this.loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
        },
        closeFullScreen() {
            this.loading.close();
        }
    },
    created() {
        eventBus.$on("progressEvent", data => {
            this.$refs.topProgress.start();
        });
        eventBus.$on("StoprogEvent", data => {
            this.$refs.topProgress.done();
        });
        eventBus.$on("alertRequest", data => {
            this.showalert(data)
        });
        eventBus.$on("LoadingEvent", data => {
            // this.openFullScreen(data)
        });
        eventBus.$on("stopLoadingEvent", data => {
            // this.closeFullScreen(data)
        });
    },
    computed: {
        // loadpage() {
        //     if(this.$store.getters.isLoading) {
        //         return this.openFullScreen()
        //     }
        //     return this.$store.getters.isLoading
        // }
    },

};
</script>

<style scoped>
.v-expansion-panel__container:hover {
    border-radius: 10px !important;
    width: 90% !important;
    margin-left: 15px !important;
    background: #e3edfe !important;
    color: #1a73e8 !important;
}

.theme--light {
    background-color: #212120 !important;
    /* background: url('storage/logo1.jpg') !important; */
    color: #fff !important;
}
</style>
