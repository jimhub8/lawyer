<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center wrap>
            <v-card class="mx-auto" width="100%">
                <v-tooltip right>
                    <v-btn icon slot="activator" class="mx-0" @click="getHistory($route.params.id)">
                        <v-icon color="blue darken-2" small>refresh</v-icon>
                    </v-btn>
                    <span>Refresh</span>
                </v-tooltip>
                <v-card dark flat>
                    <v-card-title class="pa-2 lighten-3">
                        <v-btn icon>
                            <v-icon>mdi-menu</v-icon>
                        </v-btn>
                        <h3 class="title font-weight-light text-xs-center grow" style="color: white">History</h3>
                        <v-avatar>
                            <v-img src="https://avataaars.io/?avatarStyle=Circle&topType=LongHairStraight&accessoriesType=Blank&hairColor=BrownDark&facialHairType=Blank&clotheType=BlazerShirt&eyeType=Default&eyebrowType=Default&mouthType=Default&skinColor=Light"></v-img>
                        </v-avatar>
                    </v-card-title>
                    <v-img src="https://cdn.vuetifyjs.com/images/cards/forest.jpg" gradient="to top, rgba(0,0,0,.44), rgba(0,0,0,.44)" style="height: 10vh">
                        <v-container fill-height>
                            <v-layout align-center>
                                <strong class="display-4 font-weight-regular mr-4">8</strong>
                                <v-layout column justify-end>
                                    <div class="headline font-weight-light">Monday</div>
                                    <div class="text-uppercase font-weight-light">February 2015</div>
                                </v-layout>
                            </v-layout>
                        </v-container>
                    </v-img>
                </v-card>
                <v-card-text class="py-0">
                    <v-timeline align-top dense>
                        <v-timeline-item color="pink" small v-for="history in histories" :key="history.id">
                            <v-layout pt-3>
                                <v-flex xs3>
                                    <strong>{{ history.created_at }}</strong>
                                </v-flex>
                                <v-flex>
                                    Event:<strong> {{ history.instructions }}</strong>
                                    <p>Reference No: <b>{{ history.reference_no }}</b></p>
                                    <p class="caption">Updated by: <b>{{ history.user_name }}</b></p>
                                </v-flex>
                                <!-- <v-flex xs12 lg5 mb-3>
                                    <v-expansion-panel popout>
                                        <v-expansion-panel-content>
                                            <template v-slot:header>
                                                <div>Changed Fields</div>
                                            </template>
                                            <v-card>
                                                <v-card-text>{{ history.updated_fields }}</v-card-text>
                                            </v-card>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                </v-flex> -->
                            </v-layout>
                        </v-timeline-item>
                    </v-timeline>
                </v-card-text>
            </v-card>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
export default {
    data() {
        return {
            histories: []
        }
    },
    methods: {
        getHistory(data) {
            axios.get(`history/${data}`)
                .then(response => {
                    this.histories = response.data;
                    // console.log(response);
                })
                .catch(error => {
                    // console.log(error.response);
                });
        }
    },
    mounted() {
        this.getHistory(this.$route.params.id);
    },
}
</script>

<style scoped>
.v-image__image--cover {
    height: 20vh !important;
}
</style>
