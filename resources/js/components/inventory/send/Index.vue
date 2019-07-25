<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center>
            <div class="container">
                <v-stepper v-model="e1">
                    <v-stepper-header>
                        <v-stepper-step :complete="e1 > 1" step="1">Name of step 1</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 2" step="2">Name of step 2</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 3" step="3">Name of step 3</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 4" step="4">Name of step 4</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step step="5" @click="print_p">Name of step 5</v-stepper-step>
                    </v-stepper-header>
                    <v-stepper-items>
                        <v-stepper-content step="1">
                            <v-card class="mb-5" style="padding-bottom: 30px;" color="white lighten-1">
                                <Step1 :form="form"></Step1>
                            </v-card>
                            <v-btn flat style="border: 1px solid;border-radius: 20px;" color="primary" @click="gotostep2">
                                Next
                            </v-btn>
                        </v-stepper-content>
                        <v-stepper-content step="2">
                            <v-card class="mb-5" style="padding-bottom: 30px;" color="white lighten-1">
                                <Step2 :form="form"></Step2>
                            </v-card>
                            <v-btn flat style="border: 1px solid;border-radius: 20px;" color="primary" @click="gotostep3">
                                Next
                            </v-btn>
                            <v-btn flat @click="e1 = 1" color="info" style="border: 1px solid;border-radius: 20px;">Back</v-btn>
                        </v-stepper-content>
                        <v-stepper-content step="3">
                            <v-card class="mb-5" style="padding-bottom: 30px;" color="white lighten-1">
                                <Step3 :form="form"></Step3>
                            </v-card>
                            <v-btn flat style="border: 1px solid;border-radius: 20px;" color="primary" @click="gotostep4">
                                Next
                            </v-btn>
                            <v-btn flat @click="e1 = 2" color="info" style="border: 1px solid;border-radius: 20px;">Back</v-btn>
                        </v-stepper-content>
                        <v-stepper-content step="4">
                            <v-card class="mb-5" style="padding-bottom: 30px;" color="white lighten-1">
                                <Step4 :form="form"></Step4>
                            </v-card>
                            <v-btn flat style="border: 1px solid;border-radius: 20px;" color="primary" @click="gotostep5">
                                Next
                            </v-btn>
                            <v-btn flat @click="e1 = 3" color="info" style="border: 1px solid;border-radius: 20px;">Back</v-btn>
                        </v-stepper-content>
                        <v-stepper-content step="5">
                            <v-card class="mb-5" style="padding-bottom: 30px;" color="white lighten-1">
                                <Step5 :form="form"></Step5>
                            </v-card>
                            <v-btn color="primary" @click="finish">
                                Finish
                            </v-btn>
                            <v-btn flat @click="e1 = 4" color="info" style="border: 1px solid;border-radius: 20px;">Back</v-btn>
                        </v-stepper-content>
                    </v-stepper-items>
                </v-stepper>
            </div>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
import Step1 from './steps/Step1';
import Step2 from './steps/Step2';
import Step3 from './steps/Step3';
import Step4 from './steps/Step4';
import Step5 from './steps/Step5';
export default {
    components: {
        Step1,
        Step2,
        Step3,
        Step4,
        Step5
    },
    data() {
        return {
            e1: 0,
            loading: false,
            form: {
                warehouse: '',
                client_id: null,
                sku_no: '',
                qty: '',
                shipment_package: '',
                shipping_label: "dont_generate",
                delivery_type: 'standard_delivery',
                shipment_size: '',
                delivery_date: '',
                per_box: '',
                boxes_no: null,
                no_of_boxes: '',
                tracking_no: '',
                box_arr: [],
                selectedProducts: [],
                shipping_address: [],
                boxes: [],
            },
            valid_form: false,
        }
    },
    methods: {
        gotostep2() {
            if (!this.form.warehouse) {
                this.$store.dispatch('errorEvent', 'Please select a warehouse')
                // alert('Please select a warehouse')
                return;
            }
            this.e1 = 2
        },
        gotostep3() {
            if (this.form.selectedProducts.length < 1) {
                this.$store.dispatch('errorEvent', 'Please add a product')
                // alert('Please add a product')
                return;
            }
            this.e1 = 3

        },
        gotostep4() {
            this.form.box_arr = []
            this.form.boxes = []

            if (!this.form.shipment_package) {
                this.$store.dispatch('errorEvent', 'Please select how the shipment will  be packed')
                // alert('Please select how the shipment will  be packed')
                return;
            }
            if (this.form.shipment_package === "Multiple sku" && this.form.no_of_boxes === '') {
                this.$store.dispatch('errorEvent', 'Please enter quantity')
                // alert('Please enter quantity')
                return;
            }
            this.e1 = 4
            console.log(this.form.selectedProducts.length);

            for (let i = 0; i < this.form.selectedProducts.length; i++) {
                const element = this.form.selectedProducts[i];
                for (let i = 0; i < this.form.no_of_boxes; i++) {
                    this.form.box_arr.push({
                        ind: i + 1,
                        product_id: element.id,
                        status: 'Awaiting',
                        arrived: false,
                        completed: false,
                        last_updated: new Date(),
                    })
                }
            }
            for (let i = 0; i < this.form.no_of_boxes; i++) {
                this.form.boxes.push({
                    tracking_no: '',
                    no_of_items_per_boxes: '',
                    status: 'Awaiting',
                    arrived: false,
                    completed: false,
                    last_updated: new Date(),
                })
            }

            if (this.form.shipment_package === 'Single Sku') {
                this.form.no_of_boxes === ''
                this.form.box_arr = []
                this.form.boxes = []
            }
        },
        gotostep5() {
            var cont = true
            if (this.form.shipment_package === "Multiple sku") {
                this.form.selectedProducts.forEach(element => {
                    var box_qty = 0
                    this.form.box_arr.forEach(box_a => {
                        if (element.id == box_a.product_id) {
                            box_qty = parseInt(box_qty) + parseInt(box_a.no_of_items);
                        }
                    });
                    if (box_qty != parseInt(element.qty)) {
                        this.$store.dispatch('errorEvent', "Quantity entered don't not with the products quantity")
                        // alert('quanty not match')
                        cont = false
                        return;
                    } else {
                        cont = true
                    }
                });
            }
            // var items = 0
            // var qty = 0
            // for (let i = 0; i < this.form.selectedProducts.length; i++) {
            //     const element = this.form.selectedProducts[i];
            //     for (let j = 0; j < this.form.boxes.length; j++) {
            //         // if (i == j) {
            //         const box_count = this.form.boxes[j];
            //         console.log('box   ' + box_count.no_of_items_per_boxes);
            //         // if (!boxerrort.no'Fill all the boxes'{
            //     alert('Fill all the boxes')
            //         //     return
            //         // }
            //         items = parseInt(box_count.no_of_items_per_boxes) + parseInt(items)
            //         // continue
            //         // }
            //     }
            //     // if (items !=error 'Quantity do not match'
            //     alert('Quantity do not match')
            //     //     // return
            //     // }
            //     console.log('qty ' + element.qty);
            //     qty = parseInt(element.qty) + parseInt(qty)
            // }
            // console.log('items ' + items);
            // console.log('quantity ' + qty);
            if (cont) {
                this.e1 = 5
            }

        },
print_p() {
                this.e1 = 5

},
        finish() {
            this.loading = true
            for (let i = 0; i < this.form.boxes.length; i++) {
                const element = this.form.boxes[i];
                if (!element.tracking_no) {
                    this.loading = false
                    this.$store.dispatch('errorEvent', 'Fill all the tracking no.')
                    // alert('Fill all the tracking no.')
                    return
                }
            }
            // this.e1 = 1
            axios.post('/receive', this.$data.form).then((response) => {
                this.$store.dispatch('alertEvent', 'Inventory sent')
                this.loading = false
                // console.log(response);
                // context.commit('getProducts', response.data)
                // eventBus.$emit('productEvent', data)
                // this.close()
            }).catch((error) => {
                // console.log(error.response);
                this.loading = false

            })
        }
    },
}
</script>
