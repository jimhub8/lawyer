<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div style="width: 100%;">
                    <v-card style="background: rgba(5, 117, 230, 0.16);">
                        <v-layout wrap>
                            <!-- <v-flex xs4 sm3 offset-sm4>
                                <v-select :items="AllRoles" v-model="select" label="Select Role" single-line item-text="name" item-value="name" return-object persistent-hint></v-select>
                            </v-flex> -->
                            <!-- <v-spacer></v-spacer> -->
                            <v-flex xs4 sm3>
                                <v-btn raised color="info" @click="sort">Filter</v-btn>
                            </v-flex>
                        </v-layout>
                    </v-card>
                    <!-- users display -->
                    <v-card-title>
                        Users
                        <!-- <download-excel :data="users" :fields="json_fields">
                            Export
                            <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                        </download-excel> -->
                        <v-btn slot="activator" color="primary" dark flat @click="openAdd">Add User</v-btn>
                        <v-btn slot="activator" color="orange" dark flat @click="openDeleted">Deleted Users</v-btn>
                        <v-tooltip right>
                            <v-btn icon slot="activator" class="mx-0" @click="getUsers">
                                <v-icon color="blue darken-2" small>refresh</v-icon>
                            </v-btn>
                            <span>Refresh</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line></v-text-field>
                    </v-card-title>
                    <v-flex sm12>
                        <section style="overflow: scroll;">
                            <b-table :data="isEmpty ? [] : users.data" :bordered="isBordered" :striped="isStriped" :narrowed="isNarrowed" :hoverable="isHoverable" :loading="isLoading" :focusable="isFocusable" :mobile-cards="hasMobileCards" :paginated="isPaginated" :per-page="perPage" :current-page.sync="currentPage" default-sort="name" default-sort-direction="desc">
                                <template slot-scope="props">
                                    <b-table-column sortable field="id" label="ID" width="40" numeric style="cursor: pointer">
                                        <a @click="openEdit(props.row)">{{ props.row.id }}</a>
                                    </b-table-column>
                                    <b-table-column sortable field="name" label="NAME" width="40">
                                        {{ props.row.name }}
                                    </b-table-column>
                                    <b-table-column sortable field="email" label="EMAIL">
                                        {{ props.row.email }}
                                    </b-table-column>
                                    <b-table-column sortable field="created_at" label="CREATED ON" centered>
                                        <span class="tag is-info">
                                            {{ props.row.created_at }}
                                        </span>
                                    </b-table-column>
                                    <b-table-column sortable field="status" label="STATUS">
                                        {{ props.row.status }}
                                    </b-table-column>

                                    <b-table-column field="" label="ACTION">
                                        <v-tooltip bottom>
                                            <v-btn icon class="mx-0" @click="openEdit(props.row)" slot="activator">
                                                <v-icon small color="blue darken-2">edit</v-icon>
                                            </v-btn>
                                            <span>Edit</span>
                                        </v-tooltip>
                                        <v-tooltip bottom>
                                            <v-btn icon class="mx-0" @click="openShow(props.item)" slot="activator">
                                                <v-icon small color="blue darken-2">visibility</v-icon>
                                            </v-btn>
                                            <span>View user</span>
                                        </v-tooltip>
                                        <v-tooltip bottom>
                                            <v-btn icon class="mx-0" @click="openPerm(props.item)" slot="activator">
                                                <v-icon small color="orange darken-2">dialpad</v-icon>
                                            </v-btn>
                                            <span>Edit Permissions</span>
                                        </v-tooltip>
                                        <v-tooltip bottom>
                                            <v-btn icon class="mx-0" @click="deleteItem(props.item)" slot="activator">
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
                    <!-- users display -->
                </div>
            </v-layout>
        </v-container>
        <div v-show="loader" style="text-align: center; width: 100%;">
            <v-progress-circular :width="3" indeterminate color="green" style="margin: 1rem"></v-progress-circular>
        </div>
    </v-content>
    <AddUser></AddUser>
    <EditUser></EditUser>
    <PermUser></PermUser>
    <UserProfile></UserProfile>
    <DeletedUsers></DeletedUsers>
</div>
</template>

<script>
import AddUser from "./AddUser.vue";
import PermUser from './Permission.vue';
import DeletedUsers from './DeletedUsers.vue';
import EditUser from "./EditUser.vue";
import UserProfile from './UserProfile'
export default {
    props: ["user"],
    components: {
        AddUser,
        PermUser,
        EditUser,
        UserProfile,
        DeletedUsers
    },
    data() {
        return {
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
            perPage: 5,
            search: '',
            permEdit: false,

        };
    },
    methods: {
        openDeleted() {
            eventBus.$emit('openDeletedEvent')
        },
        openAdd() {
            eventBus.$emit('openCreateUserEvent')
        },
        openEdit(item) {
            eventBus.$emit('openEditUserEvent', item)
        },
        openPerm(item) {

        },
        openShow(item) {

        },
        sort() {
            this.loading = true;
            axios
                .post("/getSorted", this.select)
                .then(response => {
                    this.loading = false;
                    this.users = response.data;
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        deleteItem(item) {
            if (confirm("Are you sure you want to delete this item?")) {
                this.loading = true;
                const index = this.users.indexOf(item)
                axios
                    .delete(`/users/${item.id}`)
                    .then(response => {
                        this.loading = false;
                        this.message = "deleted successifully";
                        this.color = "red";
                        this.snackbar = true;
                        this.users.splice(index, 1);
                    })
                    .catch(error => {
                        this.loading = false;
                        this.errors = error.response.data.errors;
                        this.message = "something went wrong";
                        this.color = "red";
                        this.snackbar = true;
                    });
            }
        },
        close() {
            this.dispAdd = this.dispShow = this.permEdit = this.dispEdit = this.dispShow = false;
        },
        getUsers() {
            this.$store.dispatch('getUsers')
                .then(() => {
                    this.loader = false
                })
        },
    },
    computed: {
        users() {
            return this.$store.getters.users
        },
        isLoading() {
            return this.$store.getters.loading;
        },
    },
    mounted() {
        this.loader = true;
        this.getUsers();
    },
    // beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //         if (vm.user.can["view users"]) {
    //             next();
    //         } else {
    //             next("/unauthorized");
    //         }
    //     });
    // },

    created() {
        eventBus.$on('userEvent', data => {
            this.getUsers()
        })
    },
};
</script>

<style scoped>
.content--wrap {
    margin-top: -100px;
}

#profile {
    width: 70px;
    height: 60px;
    border-radius: 50%;
    margin-left: 80px;
    margin-top: -30px;
}

i {
    padding: 7px;
    background: #f0f0f0;
    border-radius: 50%;
}

.list-group-item:hover,
.list-group-item:focus {
    z-index: 1;
    background: #f9f9f9;
    text-decoration: none;
}
</style>
