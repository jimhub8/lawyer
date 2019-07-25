<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px" v-if="dialog">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add User</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap v-show="!loader">
                        <v-form ref="form" @submit.prevent>
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.name" color="blue darken-2" label="Full name" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.email" color="blue darken-2" label="Email" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.address" color="blue darken-2" label="Address" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.city" color="blue darken-2" label="City" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.city">{{ errors.city[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.phone" color="blue darken-2" label="Phone" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                    </v-flex>
                                    <div class="form-group col-md-6">
                                        <label class="col-md-6 col-form-label text-md-right" for="">Role</label>
                                        <select class="custom-select custom-select-md col-md-12" v-model="form.role_id">
                                            <option v-for="roles in roles" :key="roles.id" :value="roles.name">{{ roles.name }}</option>
                                        </select>
                                        <small class="has-text-danger" v-if="errors.role_id">{{ errors.role_id[0] }}</small>
                                    </div>

                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn flat @click="resetForm">reset</v-btn>
                                <v-btn flat @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" flat color="primary" @click="save" :loading="loading">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-layout>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data() {
        const defaultForm = Object.freeze({
            name: "",
            email: "",
            phone: "",
            address: "",
            city: ""
        });
        return {
            loading: false,
            errors: [],
            selected: [],
            permissions: [],
            defaultForm,
            dialog: false,
            e1: true,
            form: Object.assign({}, defaultForm),
        };
    },
    methods: {
        save() {
            this.loading = true;
            axios
                .post("/users", this.$data.form)
                .then(response => {
                    // alert('error1')
                    this.loading = false;
                    this.$store.dispatch('getUsers')
                    this.$store.dispatch('alertEvent', 'User created')
                    // console.log(response);
                    this.close();
                    // this.resetForm();
                })
                .catch(error => {
                    // alert('error2')
                    this.loading = false;
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    }
                    this.errors = error.response.data.errors
                    console.log(error);
                    this.errors = error.response.data.errors;
                });
        },
        getRoles() {
            this.$store.dispatch('getRoles')
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm);
            this.$refs.form.reset();
        },
        close() {
            this.dialog = false
        }
    },
    created() {
        eventBus.$on('openCreateUserEvent', data => {
            this.dialog = true
            this.getRoles()
        })
    },
    computed: {
        formIsValid() {
            return (
                this.form.name &&
                this.form.email &&
                this.form.phone &&
                this.form.address &&
                this.form.city
            );
        },
        roles() {
            return this.$store.getters.roles;
        },
    },
    mounted() {}
};
</script>
