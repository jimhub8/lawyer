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
                            <v-btn color="primary" flat>Cases</v-btn>
                            <v-btn color="info" flat>Open</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="openCreate">Add Case</v-btn>
                            <!-- <v-btn flat color="primary" @click="openEdit(selected)">Edit</v-btn> -->
                        </v-card-title>
                        <VDivider />
                        <v-card-title id="filter">
                            <v-layout row wrap>
                                <v-flex sm2>
                                    <label for="">Practice Area</label>
                                    <el-select v-model="form.practice_area" clearable placeholder="Select">
                                        <el-option v-for="item in practice_area" :key="item.id" :label="item.area" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </v-flex>
                                <v-flex sm2>
                                    <label for="">Leading Attoney</label>
                                    <el-select v-model="form.leading_attoney" clearable placeholder="Select">
                                        <el-option v-for="item in users.data" :key="item.id" :label="item.name" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </v-flex>
                                <v-flex sm2>
                                    <label for="">Case Stage</label>
                                    <el-select v-model="form.case_stage" clearable placeholder="Select">
                                        <el-option v-for="item in case_stage" :key="item.id" :label="item.stage" :value="item.id">
                                        </el-option>
                                    </el-select>
                                </v-flex>
                                <v-flex sm2>
                                    <v-checkbox v-model="checkbox" label="Show only my cases"></v-checkbox>
                                </v-flex>
                                <v-flex sm2>
                                    <v-btn color="black" flat @click="filterCases">Apply Filter</v-btn>
                                </v-flex>
                                <v-flex sm2>
                                    <v-btn color="info" flat>Clear Filter</v-btn>
                                </v-flex>
                            </v-layout>
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
                                    <!-- <v-tooltip bottom>
                                        <v-btn icon class="mx-0" @click="openEvent(props.row)" slot="activator">
                                            <v-icon small color="info darken-2">visibility</v-icon>
                                        </v-btn>
                                        <span>View</span>
                                    </v-tooltip> -->
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
            checkbox: false,
            loading: false,
            isEmpty: false,
            loader: false,
            search: '',
            selected: [],
            form: {},
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

            options: [{
                value: 'Option1',
                label: 'Option1'
            }, {
                value: 'Option2',
                label: 'Option2'
            }, {
                value: 'Option3',
                label: 'Option3'
            }, {
                value: 'Option4',
                label: 'Option4'
            }, {
                value: 'Option5',
                label: 'Option5'
            }],
            value: ''
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
            this.$store.dispatch('getCases');
        },
        getcaseStage() {
            this.$store.dispatch('getcaseStage');
        },
        getFirms() {
            this.$store.dispatch('getFirms')
        },
        getClients() {
            this.$store.dispatch('getClients')
        },
        getStatus() {
            this.$store.dispatch('getStatus')
        },
        getPracticeArea() {
            this.$store.dispatch('getPracticeArea')
        },
        getUsers() {
            this.$store.dispatch('getUsers')
        },
        filterCases() {
            this.$store.dispatch('filterCases', this.form);
        },
        deleteItem(item) {
            console.log(item)
            const index = this.$store.getters.cases.indexOf(item);
            if (confirm("Are you sure you want to delete this item?")) {
                axios
                    .delete(`/cases/${item.id}`)
                    .then(response => {
                        this.$store.getters.cases.splice(index, 1);
                        // console.log(response);
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
        case_stage() {
            return this.$store.getters.case_stage
        },
        status() {
            return this.$store.getters.status
        },
        clients() {
            return this.$store.getters.clients
        },
        practice_area() {
            return this.$store.getters.practice_area
        },
        users() {
            return this.$store.getters.users
        },
    },
    mounted() {
        // this.$store.dispatch('getCases');
        this.getcaseStage();
        this.getCases();
        this.getStatus()
        this.getClients()
        this.getPracticeArea()
        this.getUsers()
        this.getFirms()
    },
    created() {
        eventBus.$on('boxEvent', data => {
            this.getCases();
        })
    },
}
</script>

<style scoped>
.el-select,
label {
    margin: 1px 5px !important;
    color: #4d4a4a !important;
}

.v-input--selection-controls.v-input .v-label {
    font-size: 10px !important;
}

.v-input--selection-controls {
    margin-top: 26px !important;
}

#filter .theme--light.v-btn {
    margin-top: 24px !important;
    border: 1px solid !important;
    border-radius: 7px !important;
}
</style>
