<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Case</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <VCard style="width: 100%">
                            <v-flex sm12>
                                <v-card-text>
                                    <div>
                                        <label for="">Client</label>
                                        <el-select v-model="form.client_id" clearable placeholder="Client" style="width: 100%;">
                                            <el-option v-for="item in clients.data" :key="item.id" :label="item.name" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div>
                                        <label for="">Firm</label>
                                        <el-select v-model="form.firm_id" clearable placeholder="Firm" style="width: 100%;">
                                            <el-option v-for="item in firms" :key="item.id" :label="item.name" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div>
                                        <label for="">Case No.</label>
                                        <el-input placeholder="case no" v-model="form.case_no"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Case</label>
                                        <el-input placeholder="Full name" v-model="form.case"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Case stage</label>
                                        <el-input placeholder="email" v-model="form.case_stage"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Firm member</label>
                                        <el-input placeholder="firm member" v-model="form.firm_member"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Status</label>
                                        <el-select v-model="form.status" clearable placeholder="Status" style="width: 100%;">
                                            <el-option v-for="item in status" :key="item.id" :label="item.status" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </div>

                                </v-card-text>
                            </v-flex>
                        </VCard>
                    </v-layout>

                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" flat @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="save" :loading="loading" :disabled="loading">Update</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        loading: false,
        form: {},
    }),

    created() {
        eventBus.$on("openEditBox", data => {
            this.dialog = true;
            this.form = data
            this.getStatus()
            this.getClients()
            this.getFirms()
        });
    },
    computed: {
        firms() {
            return this.$store.getters.firms
        }
    },
    methods: {
        save() {
            eventBus.$emit("LoadingEvent");
            this.loading = true;
            axios
                .patch(`/cases/${this.form.id}`, this.$data.form)
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    // context.commit('getBoxes', response.data)
                    this.$store.dispatch('alertEvent', 'Client Updated')
                    eventBus.$emit("boxEvent", data);
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

        getFirms() {
            this.$store.dispatch('getFirms')
        },
        getClients() {
            this.$store.dispatch('getClients')
        },
        getStatus() {
            this.$store.dispatch('getStatus')
        }
    },

    computed: {
        firms() {
            return this.$store.getters.firms
        },
        status() {
            return this.$store.getters.status
        },
        clients() {
            return this.$store.getters.clients
        },
    },
};
</script>
