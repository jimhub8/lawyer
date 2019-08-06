<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Edit Role</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="dialog = false">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 sm12>
                            <v-text-field v-model="form.name" color="blue darken-2" label="Role" required></v-text-field>
                            <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                        </v-flex>
                        <v-layout wrap>
                            <v-flex v-for="(perm, index) in permissions" :key="index" xs6 sm3>
                                <v-checkbox v-model="selected" :label="perm.name" :value="perm.name"></v-checkbox>
                            </v-flex>
                        </v-layout>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn flat @click="resetForm">reset</v-btn>
                    <v-btn flat @click="dialog = false">Close</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn :disabled="loading" flat color="primary" @click="save" :loading="loading">Submit</v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data() {
        return {
            form: {},
            loading: false,
            dialog: false,
            selected: [],
        };
    },
    methods: {
        save() {
            this.loading = true;
            axios
                .patch(`/roles/${this.form.id}`, {
                    form: this.form,
                    selected: this.selected
                })
                .then(response => {
                    this.loading = false;
            this.$store.dispatch('getRoles')
                    eventBus.$emit('alertRequest', 'Role updated')
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm);
            this.$refs.form.reset();
        },
        close() {
            this.dialog = true
        }
    },
    created() {
        eventBus.$on("RolepermEvent", data => {
            this.selected = data;
        });
        eventBus.$on("openEditRoleEvent", data => {
            this.dialog = true;
            this.form = data
        });
    },
    computed: {
        permissions() {
            this.$store.getters.user_perm
        },
        // sortPerm() {
        //     return _.orderBy(this.permissions, 'name', 'asc')
        // }
    },
};
</script>
