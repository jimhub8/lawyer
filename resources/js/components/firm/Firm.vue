<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div class="container">
                    <v-card>
                        <h3 class="text-center">Firms</h3>
                        <v-divider></v-divider>
                        <v-card-title>
                            <v-tooltip right>
                                <v-btn icon slot="activator" class="mx-0" @click="getFirms">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                                <span>Refresh</span>
                            </v-tooltip>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="openCreate">Add Firm</v-btn>
                            <!-- <v-btn flat color="primary" @click="openEdit(selected)">Edit</v-btn> -->
                        </v-card-title>
                        <vue-good-table class="table-hover" :columns="columns" :rows="firms" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" :sort-options="{enabled: true, initialSortBy: {field: 'name', type: 'asc'}}" v-loading="isLoading">
                            <template slot="table-row" slot-scope="props">

                                <span v-if="props.column.field == 'created_at'">
                                    <span>
                                        <el-tag type="success">{{props.row.created_at}}</el-tag>
                                    </span>
                                </span>
                                <span v-else-if="props.column.field == 'actions'">
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
                                </span>
                                <span v-else>
                                    {{props.formattedRow[props.column.field]}}
                                </span>
                            </template>
                        </vue-good-table>
                    </v-card>
                </div>
            </v-layout>
        </v-container>
    </v-content>
    <Create></Create>
    <Edit></Edit>
    <!-- <Show></Show> -->
</div>
</template>

<script>
import Create from './Create';
import Edit from './Edit';
// import Show from './Show';
export default {
    components: {
        Create,
        Edit,
        // Show
    },
    data() {
        return {
            loading: false,
            isEmpty: false,
            loader: false,
            search: '',
            selected: [],

            columns: [{
                    label: 'Id#',
                    field: 'id',
                    type: 'number',
                },
                {
                    label: 'Firm name',
                    field: 'name',
                },
                {
                    label: 'Created On',
                    field: 'created_at',
                    type: 'date',
                    dateInputFormat: 'YYYY-MM-DD',
                    dateOutputFormat: 'MMM Do YYYY',
                },
                {
                    label: 'Actions',
                    field: 'actions',
                },
            ],
            isPaginated: true,
            currentPage: 1,
            perPage: 5,
            items: ['Activate Box', 'Deactivate Box', 'Delete Box'],
        }
    },
    methods: {
        openCreate() {
            eventBus.$emit('openCreateBox')
        },

        openEdit(data) {
            eventBus.$emit('openEditBox', data)
        },

        openShow(data) {
            eventBus.$emit('openShowBox', data)
        },
        getFirms() {
            eventBus.$emit("LoadingEvent");
            this.$store.dispatch('getFirms');
        },
        deleteItem(item) {
            console.log(item)
            const index = this.$store.getters.firms.indexOf(item);
            if (confirm("Are you sure you want to delete this item?")) {
                axios
                    .delete(`/firms/${item.id}`)
                    .then(response => {
                        this.$store.getters.firms.splice(index, 1);
                        //// console.log(response);
                    })
                    .catch(error => (this.errors = error.response.data.errors));
            }
        },
    },
    computed: {
        firms() {
            return this.$store.getters.firms
        },
        isLoading() {
            return this.$store.getters.loading;
        },
    },
    mounted() {
        eventBus.$emit("LoadingEvent");
        // this.$store.dispatch('getFirms');
        this.getFirms();
    },
    created() {
        eventBus.$on('boxEvent', data => {
            this.getFirms();
        })
    },
}
</script>
