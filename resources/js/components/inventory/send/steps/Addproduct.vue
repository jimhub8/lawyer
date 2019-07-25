<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Product</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 sm6>
                            <v-text-field label="Product name*" required v-model="form.product_name"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-text-field label="Sku Number" v-model="form.sku_no"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-text-field label="Barcode*" persistent-hint v-model="form.bar_code" required></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-text-field label="Weight" v-model="form.weight" required></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-text-field label="Product Type" v-model="form.product_type" required></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6>
                            <v-text-field label="Brand" v-model="form.brand" required></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
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
        dialog: false,
        loading: false,
        form: {},
    }),
    created() {
        eventBus.$on('openCreateProduct', data => {
            this.dialog = true
        })
    },

    methods: {
        save() {
            this.loading = true
            axios.post('products', this.$data.form).then((response) => {
                this.loading = false
                // console.log(response);
                // context.commit('getProducts', response.data)
                eventBus.$emit('productEvent', data)
                this.close()
            }).catch((error) => {
                // console.log(error.response);
                this.loading = false

            })
        },
        close() {
            this.dialog = false
        }
    },
}
</script>
