<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Task</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-layout row wrap>
                    <v-flex sm5 style="margin: 10px 20px">
                        <div>
                            <label for="">Task</label>
                            <el-input placeholder="Task" v-model="form.task"></el-input>
                        </div>
                    </v-flex>
                    <v-flex sm5 style="margin: 10px 20px">
                        <div>
                            <label for="">Priority</label>
                            <el-input placeholder="Priority" v-model="form.priority"></el-input>
                        </div>
                    </v-flex>
                    <v-flex sm5 style="margin: 10px 20px">
                        <div>
                            <label for="">Due date </label>
                            <br>
                            <el-date-picker v-model="form.due_date" type="date" placeholder="Pick a day">
                            </el-date-picker>
                        </div>
                    </v-flex>
                    <v-flex sm5 style="margin: 10px 20px">
                        <div>
                            <label for="">Case</label>
                            <br>
                            <el-select v-model="form.case" clearable filterable placeholder="Select Case">
                                <el-option v-for="item in cases.data" :key="item.id" :label="item.case" :value="item.id">
                                </el-option>
                            </el-select>
                        </div>
                    </v-flex>
                    <v-flex sm5 style="margin: 10px 20px">
                        <div>
                            <label for="">Assigned to</label>
                            <el-select v-model="form.assigned_to" clearable filterable placeholder="Assigned to">
                                <el-option v-for="item in users.data" :key="item.id" :label="item.name" :value="item.id">
                                </el-option>
                            </el-select>
                        </div>
                    </v-flex>
                </v-layout>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" flat @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="save" :loading="loading" :disabled="loading">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data: () => ({
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
        dialog: false,
        loading: false,
        form: {},
    }),
    created() {
        eventBus.$on("openCreateBox", data => {
            this.dialog = true;
            this.getCases()
            this.getUsers()
            this.getTasks()
        });
    },
    computed: {
        tasks() {
            return this.$store.getters.tasks
        },
        cases() {
            return this.$store.getters.cases
        },
        users() {
            return this.$store.getters.users
        },
    },
    methods: {
        save() {
            eventBus.$emit("LoadingEvent");
            this.loading = true;
            axios
                .post("tasks", this.$data.form)
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    // context.commit('getBoxes', response.data)
                    this.$store.dispatch('getTasks');
                    this.$store.dispatch('alertEvent', 'Task added')
                    this.close();
                })
                .catch(error => {
                    eventBus.$emit("stopLoadingEvent");
                    // console.log(error.response);
                    this.loading = false;
                });
        },
        close() {
            this.dialog = false;
        },
        getTasks() {
            this.$store.dispatch('getTasks')
        },
        getCases() {
            this.$store.dispatch('getCases')
        },
        getUsers() {
            this.$store.dispatch('getUsers')
        },
    }
};
</script>

<style scoped>
.el-select,
.el-date-editor.el-input,
.el-date-editor.el-input__inner {
    width: 100% !important;
}
</style>
