<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div class="container">
                    <v-card>
                        <h3 class="text-center">Cases</h3>
                        <v-divider></v-divider>
                        <v-card-title>
                            <v-tooltip right>
                                <v-btn icon slot="activator" class="mx-0" @click="getCases">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                                <span>Refresh</span>
                            </v-tooltip>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="openCreate">Add Case</v-btn>
                            <!-- <v-btn flat color="primary" @click="openEdit(selected)">Edit</v-btn> -->
                        </v-card-title>
                        <vue-good-table class="table-hover" :columns="columns" :rows="cases.data" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" :sort-options="{enabled: true, initialSortBy: {field: 'name', type: 'asc'}}" v-loading="isLoading">
                            <template slot="table-row" slot-scope="props">

                                <span v-if="props.column.field == 'created_at'">
                                    <span>
                                        <el-tag type="success">{{props.row.created_at}}</el-tag>
                                    </span>
                                </span>
                                <span v-else-if="props.column.field == 'firm_name'">
                                    <span>
                                       {{props.row.firm.name}}
                                    </span>
                                </span>
                                <span v-else-if="props.column.field == 'status_title'">
                                    <span>
                                       <el-tag type="info">{{props.row.status.status}}</el-tag>
                                    </span>
                                </span>
                                <span v-else-if="props.column.field == 'client_name'">
                                    <span>
                                       {{props.row.client.name}}
                                    </span>
                                </span>
                                <span v-else-if="props.column.field == 'leading_a'">
                                    <span>
                                       {{props.row.leading_attoney.name}}
                                    </span>
                                </span>
                                <span v-else-if="props.column.field == 'practice_a'">
                                    <span>
                                       {{props.row.practice_area.area}}
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
                                        <v-btn icon class="mx-0" @click="openShow(props.row)" slot="activator">
                                            <v-icon small color="info darken-2">visibility</v-icon>
                                        </v-btn>
                                        <span>View</span>
                                    </v-tooltip>
                                    <v-tooltip bottom>
                                        <v-btn icon class="mx-0" @click="openEvent(props.row)" slot="activator">
                                            <v-icon small color="info darken-2">visibility</v-icon>
                                        </v-btn>
                                        <span>View</span>
                                    </v-tooltip>
                                    <v-tooltip bottom>
                                        <v-btn icon class="mx-0" @click="deleteItem(props.row)" slot="activator">
                                            <v-icon small color="pink darken-2">delete</v-icon>
                                        </v-btn>
                                        <span>Delete</span>
                                    </v-tooltip>
                                </span>
                                <span v-else>
                                    {{ props.formattedRow[props.column.field] }}
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
    <Show></Show>
</div>
</template>

<script>
import Create from './Create';
import Edit from './Edit';
import Show from './Show';
export default {
    components: {
        Create,
        Edit,
        Show
    },
    data() {
        return {
            loading: false,
            isEmpty: false,
            loader: false,
            search: '',
            selected: [],

            columns: [{
                    label: 'Case No',
                    field: 'case_no',
                },
                {
                    label: 'Case',
                    field: 'case',
                },
                {
                    label: 'Case Stage',
                    field: 'case_stage',
                },
                {
                    label: 'Client name',
                    field: 'client_name',
                },
                {
                    label: 'Firm',
                    field: 'firm_name',
                },
                {
                    label: 'Firm Member',
                    field: 'firm_member',
                },
                {
                    label: 'Status',
                    field: 'status_title',
                },
                {
                    label: 'Practice area',
                    field: 'practice_a',
                },
                {
                    label: 'Leading Attoney',
                    field: 'leading_a',
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
            eventBus.$emit('openShowEvent', data)
        },
        openEvent(data) {
            eventBus.$emit('openShowEvent', data)
        },
        getCases() {
            eventBus.$emit("LoadingEvent");
            this.$store.dispatch('getCases');
        },
        deleteItem(item) {
            console.log(item)
            const index = this.$store.getters.cases.indexOf(item);
            if (confirm("Are you sure you want to delete this item?")) {
                axios
                    .delete(`/cases/${item.id}`)
                    .then(response => {
                        this.$store.getters.cases.splice(index, 1);
                        //// console.log(response);
                    })
                    .catch(error => (this.errors = error.response.data.errors));
            }
        },
    },
    computed: {
        cases() {
            return this.$store.getters.cases
        },
        isLoading() {
            return this.$store.getters.loading;
        },
    },
    mounted() {
        eventBus.$emit("LoadingEvent");
        // this.$store.dispatch('getCases');
        this.getCases();
    },
    created() {
        eventBus.$on('boxEvent', data => {
            this.getCases();
        })
    },
}
</script>
