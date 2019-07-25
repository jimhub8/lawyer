<template>
<div>
    <v-layout wrap>
        <v-btn @click="lablePrint">print</v-btn>
        <v-flex sm12>
            <p>In this step you need to download each of the packing slips and put them on the outside of the box exposing the barcode. You can put them in a packing slip envelope, so long as the barcode is exposed.</p>
            <h4 class="text-center">DOWNLOAD AND AFFIX ALL LABELS ON BOXES TO AVOID ADDITIONAL PROCESSING CHARGES!</h4>
            <v-divider></v-divider>
            <v-layout wrap>
                <v-flex sm8>
                    <v-layout wrap>
                        <v-flex sm5>
                            <h3>Tracking information</h3>
                            <h4>Add tracking number for SKU Name</h4>
                        </v-flex>
                        <v-flex sm5>
                            <v-btn color="primary" class="white--text" raised>
                                <v-icon right dark>cloud_download</v-icon>
                                Upload
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-flex>
                <p>By providing us with the contents of your boxes, you help us receive your shipments more efficiently and improve your inventory accuracy. We highly recommend providing this information for each of your shipments.
                </p>
                <v-checkbox v-model="form.allboxes" label="All boxes have same tracking number"></v-checkbox>
            </v-layout>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Box#</th>
                        <th scope="col">Tracking number </th>
                        <th scope="col">Download label</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(box, index) in form.boxes" :key="index">
                        <th scope="row">{{ index+1 }}</th>
                        <td>
                            <el-input placeholder="tracking number" v-model="box.tracking_no"></el-input>
                        </td>
                        <td>
                            <v-tooltip bottom>
                                <v-btn icon slot="activator" class="mx-0" @click="lablePrint(box.tracking_no, index+1)">
                                    <v-icon color="blue darken-2">cloud_download</v-icon>
                                </v-btn>
                                <span>Print label</span>
                            </v-tooltip>
                        </td>
                    </tr>
                </tbody>
            </table>
        </v-flex>
        <v-flex sm8>
            By providing us with the tracking numbers and correctly labeling each box, you help us receive your shipments more efficiently and improve your inventory accuracy. We highly recommend providing this information for each of your shipments.
        </v-flex>
    </v-layout>
    <myLables id="print" style="display: none"></myLables>
</div>
</template>

<script>
import myLables from '../../../printing/Lables';
export default {
    components: {
        myLables,
    },
    props: ['form'],
    data() {
        return {

        }
    },
    methods: {
        lablePrint(tracking_no, index) {
            eventBus.$emit("sendPrintEvent", {data: this.form, index, tracking_no})
        },

        printPage() {
            // Get HTML to print from element
            const prtHtml = document.getElementById('print').innerHTML;

            // Get all stylesheets HTML
            let stylesHtml = '';
            for (const node of [...document.querySelectorAll('link[rel="stylesheet"], style')]) {
                stylesHtml += node.outerHTML;
            }

            // Open the print window
            const WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');

            WinPrint.document.write(`<!DOCTYPE html>
            <html>
            <head>
                ${stylesHtml}
            </head>
            <body>
                ${prtHtml}
            </body>
            </html>`);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            WinPrint.close();
        },
    },
    mounted () {
        console.log(this.$route.params)
        // this.lable_data = this.$route.params.data;
    },
    created () {
        eventBus.$on('printLableEvent', data => {
            this.printPage()
        })
    },

}
</script>
