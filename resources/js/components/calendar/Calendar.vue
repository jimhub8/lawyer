<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center>
            <v-flex sm12 lg3 class="pa-3 mb-3 feature-pane">
                <v-btn fab outline small absolute left color="primary" @click="$refs.calendar.prev()">
                    <v-icon dark>
                        keyboard_arrow_left
                    </v-icon>
                </v-btn>
                <v-btn fab outline small absolute right color="primary" @click="$refs.calendar.next()">
                    <v-icon dark>
                        keyboard_arrow_right
                    </v-icon>
                </v-btn>
                <br><br><br>
                <v-select v-model="type" :items="typeOptions" label="Type"></v-select>
                <v-checkbox v-model="dark" label="Dark"></v-checkbox>
                <v-select v-model="color" :items="colorOptions" label="Color"></v-select>
                <v-menu ref="startMenu" v-model="startMenu" :close-on-content-click="false" :nudge-right="40" :return-value.sync="start" transition="scale-transition" min-width="290px" lazy offset-y full-width>
                    <template v-slot:activator="{ on }">
                        <v-text-field v-model="start" label="Start Date" prepend-icon="event" readonly v-on="on"></v-text-field>
                    </template>
                    <v-date-picker v-model="start" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="startMenu = false">
                            Cancel
                        </v-btn>
                        <v-btn flat color="primary" @click="$refs.startMenu.save(start)">
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-menu>
                <v-menu v-if="hasEnd" ref="endMenu" v-model="endMenu" :close-on-content-click="false" :nudge-right="40" :return-value.sync="end" transition="scale-transition" min-width="290px" lazy offset-y full-width>
                    <template v-slot:activator="{ on }">
                        <v-text-field v-model="end" label="End Date" prepend-icon="event" readonly v-on="on"></v-text-field>
                    </template>
                    <v-date-picker v-model="end" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="endMenu = false">
                            Cancel
                        </v-btn>
                        <v-btn flat color="primary" @click="$refs.endMenu.save(end)">
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-menu>
                <v-menu ref="nowMenu" v-model="nowMenu" :close-on-content-click="false" :nudge-right="40" :return-value.sync="now" transition="scale-transition" min-width="290px" lazy offset-y full-width>
                    <template v-slot:activator="{ on }">
                        <v-text-field v-model="now" label="Today" prepend-icon="event" readonly v-on="on"></v-text-field>
                    </template>
                    <v-date-picker v-model="now" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="nowMenu = false">
                            Cancel
                        </v-btn>
                        <v-btn flat color="primary" @click="$refs.nowMenu.save(now)">
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-menu>
                <v-select v-model="weekdays" :items="weekdaysOptions" label="Weekdays"></v-select>
                <v-text-field v-if="type === 'custom-weekly'" v-model="minWeeks" label="Minimum Weeks" type="number"></v-text-field>
                <v-select v-if="hasIntervals" v-model="intervals" :items="intervalsOptions" label="Intervals"></v-select>
                <v-select v-if="type === 'custom-daily'" v-model="maxDays" :items="maxDaysOptions" label="# of Days"></v-select>
                <v-select v-if="hasIntervals" v-model="styleInterval" :items="styleIntervalOptions" label="Styling"></v-select>
            </v-flex>
            <v-flex sm12 lg9 class="pl-3">
                <v-sheet height="500">
                    <v-calendar ref="calendar" v-model="start" :type="type" :start="start" :end="end" :min-weeks="minWeeks" :max-days="maxDays" :now="now" :dark="dark" :weekdays="weekdays" :first-interval="intervals.first" :interval-minutes="intervals.minutes" :interval-count="intervals.count" :interval-height="intervals.height" :interval-style="intervalStyle" :show-interval-label="showIntervalLabel" :color="color">
                        <template v-slot:day="day">
                            <v-sheet v-if="day.day % 3 === 0" :color="color" class="white--text pa-1">
                                day slot {{ day.date }}
                            </v-sheet>
                        </template>
                        <template v-slot:header="day">
                            <div v-if="day.weekday % 2" class="day-header">
                                day-header slot {{ day.date }}
                            </div>
                        </template>
                        <template v-slot:day-body="day">
                            <div v-if="day.weekday % 3 === 2" class="day-body">
                                day-body slot {{ day.date }}
                            </div>
                        </template>

                        <template v-slot:day="{ date }">
                            <template v-for="event in eventsMap[date]">
                                <v-menu :key="event.title" v-model="event.open" full-width offset-x>
                                    <template v-slot:activator="{ on }">
                                        <div v-if="!event.time" v-ripple class="my-event" v-on="on" v-html="event.title"></div>
                                    </template>
                                    <v-card color="grey lighten-4" min-width="350px" flat>
                                        <v-toolbar color="primary" dark>
                                            <v-btn icon @click="openEdit(event)">
                                                <v-icon>edit</v-icon>
                                            </v-btn>
                                            <v-toolbar-title v-html="event.title"></v-toolbar-title>
                                            <v-spacer></v-spacer>
                                            <v-btn icon>
                                                <v-icon>favorite</v-icon>
                                            </v-btn>
                                            <v-btn icon>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                        </v-toolbar>
                                        <v-card-title primary-title>
                                            <span v-html="event.details"></span>
                                        </v-card-title>
                                        <v-card-actions>
                                            <v-btn flat color="secondary">
                                                Cancel
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-menu>
                            </template>
                        </template>
                    </v-calendar>
                </v-sheet>
            </v-flex>
        </v-layout>
    </v-container>
    <myTask></myTask>
</v-content>
</template>

<script>
import myTask from '../task/Edit'
const weekdaysDefault = [0, 1, 2, 3, 4, 5, 6]
const intervalsDefault = {
    first: 0,
    minutes: 60,
    count: 24,
    height: 40
}

const stylings = {
    default (interval) {
        return undefined
    },
    workday(interval) {
        const inactive = interval.weekday === 0 ||
            interval.weekday === 6 ||
            interval.hour < 9 ||
            interval.hour >= 17
        const startOfHour = interval.minute === 0
        const dark = this.dark
        const mid = dark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)'

        return {
            backgroundColor: inactive ? (dark ? 'rgba(0,0,0,0.4)' : 'rgba(0,0,0,0.05)') : undefined,
            borderTop: startOfHour ? undefined : '1px dashed ' + mid
        }
    },
    past(interval) {
        return {
            backgroundColor: interval.past ? (this.dark ? 'rgba(0,0,0,0.4)' : 'rgba(0,0,0,0.05)') : undefined
        }
    }
}

export default {
    components: {
        myTask,
    },
    data: () => ({
        dark: false,
        startMenu: false,
        start: new Date(),
        endMenu: false,
        end: '2019-01-27',
        nowMenu: false,
        minWeeks: 1,
        now: null,
        today: '2019-01-08',
        // events: [{
        //         title: 'Court Day',
        //         details: 'High Court!',
        //         date: '2019-12-30',
        //         open: false
        //     },
        //     {
        //         title: 'Court Day',
        //         details: 'High Court!',
        //         date: '20189-12-31',
        //         open: false
        //     },
        //     {
        //         title: 'Court Day',
        //         details: 'High Court!',
        //         date: '2019-01-01',
        //         open: false
        //     },
        //     {
        //         title: 'Meeting',
        //         details: 'Spending time on how we do not have enough time',
        //         date: '2019-01-07',
        //         open: false
        //     },
        //     {
        //         title: '30th Birthday',
        //         details: 'Celebrate responsibly',
        //         date: '2019-01-03',
        //         open: false
        //     },
        //     {
        //         title: 'New Year',
        //         details: 'Eat chocolate until you pass out',
        //         date: '2019-01-01',
        //         open: false
        //     },
        //     {
        //         title: 'Conference',
        //         details: 'Mute myself the whole time and wonder why I am on this call',
        //         date: '2019-01-21',
        //         open: false
        //     },
        //     {
        //         title: 'Hackathon',
        //         details: 'Code like there is no tommorrow',
        //         date: '2019-02-01',
        //         open: false
        //     }
        // ],
        type: 'month',
        typeOptions: [{
                text: 'Day',
                value: 'day'
            },
            {
                text: '4 Day',
                value: '4day'
            },
            {
                text: 'Week',
                value: 'week'
            },
            {
                text: 'Month',
                value: 'month'
            },
            {
                text: 'Custom Daily',
                value: 'custom-daily'
            },
            {
                text: 'Custom Weekly',
                value: 'custom-weekly'
            }
        ],
        weekdays: weekdaysDefault,
        weekdaysOptions: [{
                text: 'Sunday - Saturday',
                value: weekdaysDefault
            },
            {
                text: 'Mon, Wed, Fri',
                value: [1, 3, 5]
            },
            {
                text: 'Mon - Fri',
                value: [1, 2, 3, 4, 5]
            },
            {
                text: 'Mon - Sun',
                value: [1, 2, 3, 4, 5, 6, 0]
            }
        ],
        intervals: intervalsDefault,
        intervalsOptions: [{
                text: 'Default',
                value: intervalsDefault
            },
            {
                text: 'Workday',
                value: {
                    first: 16,
                    minutes: 30,
                    count: 20,
                    height: 40
                }
            }
        ],
        maxDays: 7,
        maxDaysOptions: [{
                text: '7 days',
                value: 7
            },
            {
                text: '5 days',
                value: 5
            },
            {
                text: '4 days',
                value: 4
            },
            {
                text: '3 days',
                value: 3
            }
        ],
        styleInterval: 'default',
        styleIntervalOptions: [{
                text: 'Default',
                value: 'default'
            },
            {
                text: 'Workday',
                value: 'workday'
            },
            {
                text: 'Past',
                value: 'past'
            }
        ],
        color: 'primary',
        colorOptions: [{
                text: 'Primary',
                value: 'primary'
            },
            {
                text: 'Secondary',
                value: 'secondary'
            },
            {
                text: 'Accent',
                value: 'accent'
            },
            {
                text: 'Red',
                value: 'red'
            },
            {
                text: 'Pink',
                value: 'pink'
            },
            {
                text: 'Purple',
                value: 'purple'
            },
            {
                text: 'Deep Purple',
                value: 'deep-purple'
            },
            {
                text: 'Indigo',
                value: 'indigo'
            },
            {
                text: 'Blue',
                value: 'blue'
            },
            {
                text: 'Light Blue',
                value: 'light-blue'
            },
            {
                text: 'Cyan',
                value: 'cyan'
            },
            {
                text: 'Teal',
                value: 'teal'
            },
            {
                text: 'Green',
                value: 'green'
            },
            {
                text: 'Light Green',
                value: 'light-green'
            },
            {
                text: 'Lime',
                value: 'lime'
            },
            {
                text: 'Yellow',
                value: 'yellow'
            },
            {
                text: 'Amber',
                value: 'amber'
            },
            {
                text: 'Orange',
                value: 'orange'
            },
            {
                text: 'Deep Orange',
                value: 'deep-orange'
            },
            {
                text: 'Brown',
                value: 'brown'
            },
            {
                text: 'Blue Gray',
                value: 'blue-gray'
            },
            {
                text: 'Gray',
                value: 'gray'
            },
            {
                text: 'Black',
                value: 'black'
            }
        ]
    }),
    computed: {
        intervalStyle() {
            return stylings[this.styleInterval].bind(this)
        },
        hasIntervals() {
            return this.type in {
                'week': 1,
                'day': 1,
                '4day': 1,
                'custom-daily': 1
            }
        },
        hasEnd() {
            return this.type in {
                'custom-weekly': 1,
                'custom-daily': 1
            }
        },

        eventsMap() {
            const map = {}
            this.events.forEach(e => (map[e.date] = map[e.date] || []).push(e))
            return map
        },
        events() {
            return this.$store.getters.events
        }
    },
    methods: {
        showIntervalLabel(interval) {
            return interval.minute === 0
        },
        getEvents() {
            this.$store.dispatch('getEvents')
        },
        openEdit(data) {
            eventBus.$emit('openEditTask', data)
        }
    },
    created () {
        eventBus.$on('TaskRefreshEvent', data => {
            this.getEvents()
        });
    },
    mounted () {
        this.getEvents();
    },
}
</script>

<style scoped>
.feature-pane {
    position: relative;
    padding-top: 30px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.day-header {
    margin: 0px 2px 2px 2px;
    padding: 2px 6px;
    background-color: #1867c0;
    color: #ffffff;
    border: 1px solid #1867c0;
    border-radius: 2px;
    user-select: none;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}

.day-body {
    position: absolute;
    top: 400px;
    height: 36px;
    margin: 2px;
    padding: 2px 6px;
    background-color: #1867c0;
    color: #ffffff;
    border: 1px solid #1867c0;
    border-radius: 2px;
    left: 0;
    right: 0;
    user-select: none;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}

.day {
    position: relative;
    height: 24px;
    margin: 0px;
    padding: 0px 6px;
    background-color: #1867c0;
    color: #ffffff;
    border: 1px solid #1867c0;
    border-radius: 2px;
    left: 0;
    right: 0;
    user-select: none;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}
.my-event {
    background: #1867c0;
    color: #fff;
}
</style>
