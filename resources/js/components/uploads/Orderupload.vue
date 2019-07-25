<template>
<v-dialog v-model="dialog" persistent width="400px">
    <v-card style="overflow-x: hidden;">
        <v-card-title>
            Upload Excel Shipments
        </v-card-title>
        <v-container grid-list-md>
            <v-card-text>
                <v-layout wrap>
                    <form action="/importOrder" method="post" enctype="multipart/form-data" style="width: 100%;">
                        <input type="hidden" name="_token" :value="csrf">
                        <!-- <el-select name="client" value="" filterable clearable placeholder="Select Client" style="width:100%; margin-bottom: 10px;">
                            <el-option v-for="item in clients.data" :key="item.id" :label="item.name" :value="item.id">
                            </el-option>
                        </el-select> -->
                        <label for="">Client</label>
                        <select class="custom-select" name="client">
                            <option selected>Select a Client</option>
                            <option v-for="item in clients.data" :key="item.id" :value="item.id">{{ item.display_name }}</option>
                        </select>
                        <div style="height: 10px;"></div>
                        <label for="">Warehouse</label>
                        <select class="custom-select" name="warehouse">
                            <option selected>Select a warehouse</option>
                            <option v-for="item in warehouses" :key="item.id" :value="item.id">{{ item.name }}</option>
                        </select>
                        <VDivider />
                        <!-- <el-select name="warehouse" value="" filterable clearable placeholder="Select Warehouse" style="width:100%">
                            <el-option v-for="item in warehouses" :key="item.id" :label="item.name" :value="item.id">
                            </el-option>
                        </el-select> -->
                        <v-btn color="red" darken-1 raised @click="onPickFile" style="color: #fff;">
                            Choose File<v-icon right dark>cloud_upload</v-icon>
                        </v-btn>
                        <input type="file" name="orders" id="csv" ref="fileInput" style="display: none">
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-btn flat @click="close">Close</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn flat type="submit" color="primary">Upload Orders</v-btn>
                        </v-card-actions>
                    </form>
                </v-layout>
            </v-card-text>
        </v-container>
    </v-card>
</v-dialog>
</template>

<script>
export default {
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            imagePlaced: false,
            dialog: false,
            form: {},
        }
    },
    methods: {
        onPickFile() {
            this.$refs.fileInput.click()
        },
        close() {
            this.dialog = false
        },

        getClients() {
            this.$store.dispatch('getClients');
        },
        getWarehouses() {
            this.$store.dispatch("getWarehouses");
        },
    },
    computed: {
        clients() {
            return this.$store.getters.clients
        },
        warehouses() {
            return this.$store.getters.warehouse;
        },
    },
    created() {
        eventBus.$on('openOrderUploadEvent', data => {
            this.dialog = true
        })
    },
    mounted() {
        this.getClients()
        this.getWarehouses()
    },
}
</script>
