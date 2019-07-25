<template>
<div>
    <v-layout wrap>
        <v-flex sm12>
            <p>How are you going to organize your products in boxes? All in one or a box for each SKU? Let us know and then let us know the dimensions. We’ll use the largest box as the basis for the labels.</p>
            <v-divider></v-divider>
            <v-layout wrap>
                <v-flex sm12>
                    <h2>Box packaging: Multiple SKU per box</h2>
                    <!-- <el-table :data="form.selectedProducts" style="width: 100%" :row-class-name="tableRowClassName">
                        <el-table-column prop="id" label="#Id" width="180"></el-table-column>
                        <el-table-column prop="product_name" label="Product Name" width="180"></el-table-column>
                        <el-table-column v-for="(box, index) in form.box_arr" :key="index" :label="'Box #' + parseInt(index+1)">
                            <div class="form-group">
                                <input type="text" class="form-control" id="formGroupExampleInput" v-model="status" placeholder="Quantity">
                            </div>
                        </el-table-column>
                        <el-table-column prop="qty" label="Quantity"></el-table-column>
                    </el-table> -->

                    <table class="table" v-if="form.box_arr.length > 0 || form.selectedProducts.length">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Last</th>
                                <th scope="col" v-for="(item, index) in (form.box_arr.length / form.selectedProducts.length)" :key="item.id">Boxes {{ index + 1 }}</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in form.selectedProducts" :key="item.id">
                                <th scope="row">1</th>
                                <td>{{ item.id }}</td>
                                <td>{{ item.product_name }}</td>
                                <td v-for="(box, index) in form.box_arr" :key="index" v-if="item.id == box.product_id">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="formGroupExampleInput" v-model="box.no_of_items" placeholder="Quantity">
                                    </div>
                                </td>
                                <td>{{ item.qty }}</td>
                            </tr>
                        </tbody>
                    </table>

                </v-flex>
                <p>By providing us with the contents of your boxes, you help us receive your shipments more efficiently and improve your inventory accuracy. We highly recommend providing this information for each of your shipments.
                </p>
                <!-- <v-btn color="orange" flat @click="total_box">Total</v-btn> -->
            </v-layout>
        </v-flex>
    </v-layout>
</div>
</template>

<script>
export default {
    props: ['form'],
    data() {
        return {
            box_it: {},
            tableRowClassName({
                row,
                rowIndex
            }) {
                if (rowIndex === 1) {
                    return 'warning-row';
                } else if (rowIndex === 3) {
                    return 'success-row';
                }
                return '';
            },
            total_item: 0,
        }
    },
    methods: {
        total_box() {
            this.total_item = 0
            this.form.selectedProducts.forEach(element => {

                this.form.boxes.forEach(element => {
                    console.log(element.no_of_items);
                    this.total_item = parseInt(this.total_item) + parseInt(element.no_of_items)
                });
            });
        },
        validate () {
            var box_qty = 0
            this.form.selectedProducts.forEach(element => {
                this.form.box_arr.forEach(box_a => {
                    if (element.id == box_a.product_id) {
                        if((parseInt(box_qty) + parseInt(box_a.no_of_items)) != parseInt(element.qty)) {
                            alert('quanty not match')
                        }
                    } else {

                    }
                });
            });
        }
    },
    // computed: {
    //     total_box() {
    //         return form.boxes.forEach(element => {
    //             element.no_of_items
    //         });
    //     }
    // },
}
</script>
