<template>
<div>
    <v-content>
        <v-container fluid fill-height>
            <v-layout justify-center align-center>
                <div v-show="loader" style="text-align: center; width: 100%;">
                    <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
                </div>
                <v-card v-show="!loader" style="width: 100%;">
                    <v-card-title>
                        Roles
                        <v-btn @click="openAdd" flat color="primary">Add Roles</v-btn>
                        <!-- <v-spacer></v-spacer> -->
                        <v-tooltip right>
                            <v-btn icon slot="activator" class="mx-0" @click="getRoles">
                                <v-icon color="blue darken-2" small>refresh</v-icon>
                            </v-btn>
                            <span>Refresh</span>
                        </v-tooltip>
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
                    </v-card-title>
                    <v-flex sm12>
                        <section style="overflow: scroll;">
                            <b-table :data="isEmpty ? [] : roles" :bordered="isBordered" :striped="isStriped" :narrowed="isNarrowed" :hoverable="isHoverable" :loading="isLoading" :focusable="isFocusable" :mobile-cards="hasMobileCards" :paginated="isPaginated" :per-page="perPage" :current-page.sync="currentPage" default-sort="name" default-sort-direction="desc">
                                <template slot-scope="props">
                                    <b-table-column sortable field="id" label="ID" width="40" numeric style="cursor: pointer">
                                        <a @click="openEdit(props.row)">{{ props.row.id }}</a>
                                    </b-table-column>
                                    <b-table-column sortable field="name" label="NAME" width="40">
                                        {{ props.row.name }}
                                    </b-table-column>
                                    <b-table-column sortable field="description" label="DESCRIPTION">
                                        {{ props.row.description }}
                                    </b-table-column>
                                    <b-table-column sortable field="created_at" label="CREATED ON" centered>
                                        <span class="tag is-info">
                                            {{ props.row.created_at }}
                                        </span>
                                    </b-table-column>
                                    <b-table-column sortable field="status" label="STATUS">
                                        {{ props.row.status }}
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
                </v-card>
            </v-layout>
        </v-container>
    </v-content>
    <AddRole></AddRole>
    <!--  <ShowRole @closeRequest="close" :openShowRequest="dispShow"></ShowRole> -->
    <EditRole></EditRole>
</div>
</template>

<script>
import AddRole from './AddRole.vue'
// // import ShowRole from './ShowRole.vue'
import EditRole from './EditRole.vue'
export default {
    props: ['user'],
    components: {
        AddRole,
        // ShowRole,
        EditRole
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
        }
    },
    methods: {
        openShow(key) {

        },
        openAdd() {
            eventBus.$emit('openCreateRoleEvent')
        },
        openEdit(item) {

        },

        deleteItem(item) {
            if (confirm('Are you sure you want to delete this item?')) {
                this.message = 'Deleting...'
                this.color = 'indigo'
                this.snackbar = true
                // this.timeout = 20000
                this.color = 'indigo'
                axios.delete(`/roles/${item}`)
                    .then((response) => {
                        this.snackbar = false
                        this.AllRoles.splice(index, 1)
                        this.message = 'deleted successifully'
                        this.color = 'red'
                        this.snackbar = true
                    })
                    .catch((error) => {
                        this.snackbar = false
                        this.message = 'something went wrong'
                        this.color = 'red'
                        this.snackbar = true
                        this.errors = error.response.data.errors
                    })
            }
        },

        getRoles() {
            this.$store.dispatch('getRoles')
                .then(() => {
                    this.loader = false
                })
        },
    },
    mounted() {
        this.loader = true
        this.getRoles()
    },
    computed: {
        roles() {
            return this.$store.getters.roles;
        },

        isLoading() {
            return this.$store.getters.loading;
        },
    },
    //   beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //       if (vm.user.can["view roles"]) {
    //         next();
    //       } else {
    //         next("/unauthorized");
    //       }
    //     });
    //   }
}
</script>

