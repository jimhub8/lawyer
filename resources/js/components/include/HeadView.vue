<template>
<v-app id="inspire">

    <v-navigation-drawer right temporary v-model="drawerRight" fixed>
        <v-list dense style="background: #f0f0f0;">
            <template>
                <Notifications></Notifications>
            </template>
        </v-list>
    </v-navigation-drawer>
    <v-navigation-drawer v-model="drawer" fixed app>
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

                    <router-link to="/clients" class="v-list__tile v-list__tile--link">
                        <div class="v-list__tile__action">
                            <i aria-hidden="true" class="icon material-icons">people_outline</i>
                        </div>
                        <div class="v-list__tile__content">
                            <div class="v-list__tile__title">Clients</div>
                        </div>
                    </router-link>

                    <router-link to="/firms" class="v-list__tile v-list__tile--link">
                        <div class="v-list__tile__action">
                            <i aria-hidden="true" class="icon material-icons">business</i>
                        </div>
                        <div class="v-list__tile__content">
                            <div class="v-list__tile__title">Firms</div>
                        </div>
                    </router-link>

                    <v-list-group prepend-icon="account_circle">
                        <v-list-tile slot="activator">
                            <v-list-tile-title>Users&Roles</v-list-tile-title>
                        </v-list-tile>
                        <router-link to="/users" class="v-list__tile theme--light" style="text-decoration: none">
                            <v-list-tile-action>
                                <v-icon>people_outline</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-title>Users</v-list-tile-title>
                        </router-link>
                        <router-link to="/roles" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action">
                                <i aria-hidden="true" class="icon material-icons">gavel</i>
                            </div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">Roles</div>
                            </div>
                        </router-link>
                    </v-list-group>
                </v-card>
            </template>
        </v-list>
    </v-navigation-drawer>
    <v-toolbar :color="color" dark fixed app>
        <v-toolbar-title style="width: 600px" class="ml-0 pl-3">
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <!-- MFT fulfillment -->
            <img src="/storage/logo.jpeg" alt style="width: 130px; height: 60px;border-radius: 20px;">
        </v-toolbar-title>
        <v-tooltip bottom>
            <v-btn icon slot="activator" class="mx-0" @click="getnotifications">
                <v-icon color="blue darken-2" small>refresh</v-icon>
            </v-btn>
            <span>Refresh</span>
        </v-tooltip>
        <VSpacer />
        <Logout :user="user"></Logout>
        <VDivider vertical style="margin-top: 0px;"/>
        <v-badge color="black" right overlap>
            <template v-slot:badge>
                {{ notifications.length }}
            </template>
            <v-btn icon @click.stop="drawerRight = !drawerRight">
                <v-icon color="white lighten-1" large>
                    notifications
                </v-icon>
            </v-btn>
        </v-badge>
    </v-toolbar>

    <v-snackbar :timeout="timeout" bottom :color="Snackcolor" right v-model="snackbar">
        {{ message }}
        <v-icon dark right>{{ icon }}</v-icon>
    </v-snackbar>
    <v-footer style="background: #e2e0e0 !important;" app>
        <span style="color: #000; margin: auto;">Mft fulfillment center &copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
</v-app>
</template>

<script>
import Notifications from "../notifications/Notification";
// // import AddShipment from "../shipments/AddShipment";
// import { vueTopprogress } from "vue-top-progress";
import Logout from "./Logout";
// import chattyNoty from '../notification/chattyNoty'
export default {
    components: {
        Notifications,
        Logout
    },
    props: ["user"],
    data() {
        return {
            icon: "",
            Snackcolor: '',
            color: "rgb(25, 117, 210)",
            loading: false,
            dialog: false,
            drawer: true,
            drawerRight: false,
            right: null,
            mode: "",
            snackbar: false,
            timeout: 5000,
            message: "Success",
        };
    },
    methods: {
        close() {
            this.dialog = false;
        },

        successAlert(data) {
            this.message = data;
            this.Snackcolor = "black";
            this.snackbar = true;
            this.icon = 'check_circle'
        },

        errorAlert(data) {
            this.message = data;
            this.Snackcolor = "red";
            this.snackbar = true;
            this.icon = 'block'
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
        },
        getnotifications() {
            this.$store.dispatch('getnotifications')
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
            this.successAlert(data)
        });
        eventBus.$on("errorEvent", data => {
            this.errorAlert(data)
        });
        eventBus.$on("LoadingEvent", data => {
            // this.openFullScreen(data)
        });
        eventBus.$on("stopLoadingEvent", data => {
            // this.closeFullScreen(data)
        });

        eventBus.$on("notificationCountEvent", data => {
            this.notification = data
        });
    },
    computed: {
        notifications() {
            return this.$store.getters.notifications
        }
    },
    mounted() {
        this.getnotifications();
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

.v-toolbar[data-booted=true] {
    transition: .2s cubic-bezier(.4, 0, .2, 1);
    z-index: 100 !important;
}

.theme--light[data-v-67cb1297] {
    z-index: 101 !important;
}
</style>
