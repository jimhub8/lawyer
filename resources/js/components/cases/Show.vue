<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="1200px">
        <v-card>
            <v-card-title>
                <h2 class="headline" style="text-align: center">Case Details</h2>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex sm6>
                            <ul class="list-group">
                                <li class="list-group-item active"><b>Case Number </b></li>
                                <li class="list-group-item"><label for="">Client Name:</label><span style="float: right;">{{ case_.client.name }}</span></li>
                                <li class="list-group-item"><label for="">Firm:</label><span style="float: right;">{{ case_.firm.name }}</span></li>
                                <li class="list-group-item"><label for="">Status:</label><span style="float: right;">{{ case_.status.status }}</span></li>
                                <li class="list-group-item"><label for="">Leading Attoney:</label><span style="float: right;">{{ case_.leading_attoney.name }}</span></li>
                            </ul>
                        </v-flex>
                        <v-flex sm6>
                            <ul class="list-group">
                                <li class="list-group-item active"><b>case </b></li>
                                <li class="list-group-item"><label for="">case stage:</label><span style="float: right;">{{ case_.case_stage }}</span></li>
                                <li class="list-group-item"><label for="">Firm member:</label><span style="float: right;">{{ case_.firm_member }}</span></li>
                            </ul>
                        </v-flex>
                        <v-flex sm6>
                            <ul class="list-group">
                                <li class="list-group-item active"><b>next event, </b></li>
                                <li class="list-group-item"><label for="">Event:</label><span style="float: right;"></span></li>
                                <li class="list-group-item"><label for="">Event Date:</label><span style="float: right;"></span></li>
                                <li class="list-group-item"><label for="">Evet Description:</label><span style="float: right;"></span></li>
                            </ul>
                        </v-flex>
                        <v-flex sm6>
                            <ul class="list-group">
                                <li class="list-group-item active"><b>Case Number </b></li>
                                <li class="list-group-item"><label for="">Client Name:</label><span style="float: right;"></span></li>
                                <li class="list-group-item"><label for="">Firm:</label><span style="float: right;"></span></li>
                                <li class="list-group-item"><label for="">Status:</label><span style="float: right;"></span></li>
                                <li class="list-group-item"><label for="">Leading Attoney:</label><span style="float: right;"></span></li>
                            </ul>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" flat @click="dialog = false">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="dialog = false">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        case_: [],
    }),
    created() {
        eventBus.$on("openShowEvent", data => {
            this.dialog = true;
            this.case_ = data
        });
    }
};
</script>
