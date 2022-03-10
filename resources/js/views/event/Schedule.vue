<template>
    <div>
        <div class="antialiased bg-gray-50 min-h-screen">
            <div class="w-full text-gray-700 bg-white shadow-sm p-4">
                <div class="flex max-w-screen-lg px-4 mx-auto items-center justify-between md:px-6 lg:px-8">
                    <div class="flex flex-row items-center justify-between">
                        <a href="/" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">LOGO HERE</a>
                    </div>
                    <nav class="pb-0 flex justify-end gap-2">
                        <button class="flex rounded-full items-center justify-center bg-gray-600 text-white h-8 w-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>
                        <button class="flex rounded-full items-center justify-center bg-blue-600 text-white h-8 w-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
            <div class="w-full">
                <div class="flex max-w-screen-lg p-8 mx-auto items-center justify-between">
                    <div id="container" class="w-full flex flex-col md:flex-row border rounded-md bg-white">
                        <div class="w-full md:w-4/12 font-medium border-r p-5">
                            <div class="text-gray-500">{{userName}}</div>
                            <div class="text-2xl font-bold text-gray-700">{{eventName}}</div>
                            <div class="flex items-center gap-2 text-gray-700 mt-4">
                                <div class="w-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">{{duration}}</div>
                            </div>
                            <div class="flex items-start gap-2 text-gray-700 mt-4">
                                <div class="w-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                    </svg>
                                </div>
                                <div class="flex-1">Video conferencing details provided upon confirmation.</div>
                            </div>
                            <div class="mt-4 text-gray-600 text-sm" v-html="meetingDetails">{{meetingDetails}}</div>
                        </div>
                        <div class="w-full md:w-8/12">
                            <div class="flex flex-col md:flex-row w-full h-full">
                                <div class="w-full md:w-8/12 p-5">
                                    <div class="mb-6 text-xl font-medium text-gray-700">Select a Date & Time</div>
                                    <!--<vc-date-picker
                                        v-model="selectedDate"
                                        is-expanded 
                                        title-position="left"
                                        :available-dates="[ 
                                            new Date('2022-01-23'),
                                            new Date('2022-01-24'),
                                        ]"
                                        :locale="{ masks: { weekdays: 'WWW' } }"
                                    >
                                    </vc-date-picker>-->
                                    <vc-date-picker
                                        v-model="selectedDate"
                                        @input="onDateChange"
                                        is-expanded 
                                        title-position="left"
                                        :min-date="mindate"
                                        :max-date="maxdate"
                                        :disabled-dates='[ { weekdays: weekdaysval } ]' 
                                        :locale="{ masks: { weekdays: 'WWW' } }"
                                    >
                                    </vc-date-picker>
                                    <TimezoneSelector ref="timezone" v-model="selectTimeZone" class="mt-4"/>
                                </div>
                                <transition name="fade">
                                    <div v-if="selectedDate" class="w-full md:w-4/12 h-full pt-5 flex flex-col">
                                        <div class="mb-5 px-5">{{ formattedSelectedDate }}</div>
                                        <div class="overflow-auto px-5 py-2">
                                        <div v-for="(item,i) in availablehours" :key="i" @click="activeTime = i" class="flex gap-2 mb-3">
                                                <div v-if="i!=activeTime" class="ring-1 w-full cursor-pointer hover:ring-2 ring-blue-500 ring-offset-0 text-blue-600 font-medium py-3 rounded-md text-center">
                                                    {{item}}
                                                </div>
                                                <div v-if="i==activeTime" class="w-6/12 py-3 cursor-pointer bg-gray-600 text-white rounded-md text-center">{{item}}</div>
                                                <div v-if="i==activeTime" @click="bookSlot()" class="w-6/12 py-3 cursor-pointer bg-blue-600 hover:bg-blue-400 text-white rounded-md text-center">Confirm</div>
                                        </div>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TimezoneSelector from '../../components/TimezoneSelector.vue'
import moment from "moment";
// import { mapState, mapActions } from "vuex";
export default {
    name: 'EventLink',
    data(){
        return {
            eventId:null,
            userId:null,
            userName:"",
            eventName:"",
            duration:"",
            meetingDetails:"",
            weekdaysval:[],
            mindate:new Date(),
            maxdate:null,
            selectedDate: null,
            showTimeSlots: false,
            activeTime: null,
            availabledatesvalue:"",
            availablehours:null,
            selectTimeZone:"UTC",
        }
    },
    computed: {
        formattedSelectedDate(){
            return moment(this.selectedDate).format('dddd, MMMM DD')
        },
    // ...mapState("schedule", {
    //   pageName: (state) => state.pageName,
    // }),
    },
    components: {
        TimezoneSelector
    },
    methods: {
        moment() {
            return moment();
        },
            onDateChange() {

                var tz = moment.tz.guess();
                var timedifference = new Date().getTimezoneOffset();

                // console.log("timezone",timedifference);

                // var timezone = this.timezone.momentTimezone.tz.names();
                // console.log("timezone",timezone);

                var clickDate = new Date(this.selectedDate);

                var clickDate_year = clickDate.getFullYear();
                var clickDate_month = clickDate.getMonth();
                var clickDate_date = clickDate.getDate();
                var clickDate_day = clickDate.getDay();

                var weekdaays_val = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];

                var clickDay_name = weekdaays_val[clickDate_day];
                var availabledates = JSON.parse(this.availabledatesvalue);

                 // console.log(availabledates[clickDay_name].length);

                 var timesArray = [];

                 availabledates[clickDay_name].map(item => {

                    console.log("loopthroughmap",item);

                    var starttime = moment(item.open,'HH:mm').add(15, 'minutes').format('hh:mm A');
                    var endtime = moment(item.close,'HH:mm').format('hh:mm A');
                    timesArray.push(starttime);
                    if(starttime>endtime){

                        console.log(starttime);
                    }




                    

                    //var dt = moment(item.open, ["h:mm a"]).format("HH:mm");
                    //var dt1 = moment(item.close, ["h:mm a"]).format("HH:mm");





                 })

                 //console.log(starttime);



                 var openval = availabledates[clickDay_name][0].open;

                 if(availabledates[clickDay_name].length==1){
                     var closeval = availabledates[clickDay_name][0].close;
                 }
                 if(availabledates[clickDay_name].length>1){

                    var closeval = availabledates[clickDay_name][availabledates[clickDay_name].length-1].close;
                 }
                


                 // console.log(availabledates[clickDay_name][0].open);
                 // console.log(availabledates[clickDay_name][0].close);

                 var dt = moment(openval, ["HH:mm"]).format("hh:mm");
                 var dt1 = moment(closeval, ["HH:mm"]).format("hh:mm");
                 // console.log('change format');
                 // console.log(dt);
                 // console.log(dt1);

                //this.availablehours = this.returnTimesInBetween(openval, closeval);

                // var newval = '2016-08-10'+' '+openval;
                // var newval2 = '2016-08-10'+' '+ closeval;

                var intervalminutes = parseInt(this.duration);
                this.availablehours = this.intervals(openval, closeval, intervalminutes);

                 // console.log('allhours', gethours);

                // console.log(availabledates[clickDay_name][0].open.split(":"));


            
            },

            intervals(startString, endString, intervaltime) {
            var start = moment(startString, 'HH:mm');
            var end = moment(endString, 'HH:mm');

            // round starting minutes up to nearest 15 (12 --> 15, 17 --> 30)
            // note that 59 will round up to 60, and moment.js handles that correctly
            start.minutes(Math.ceil(start.minutes() / intervaltime) * intervaltime);

            var result = [];

            var current = moment(start);

            while (current <= end) {
            result.push(current.format('hh:mm A'));
            current.add(intervaltime, 'minutes');
            }

            return result;
            },

            getGenTime:(timeString) => {
            let H = +timeString.substr(0, 2);
            let h = (H % 12) || 12;
            let ampm = H < 12 ? " AM" : " PM";
            return timeString = h + timeString.substr(2, 3) + ampm;
            },

            returnTimesInBetween(start, end) {
            var timesInBetween = [];

            var startH = parseInt(start.split(":")[0]);
            var startM = start.split(":")[1];
            var startM_new = parseInt(startM.split(" ")[0]);
            var endH = parseInt(end.split(":")[0]);
            var endM = end.split(":")[1];
            var endM_new = parseInt(endM.split(" ")[0]);

            if (startM_new == 30)
            startH++;

            for (var i = startH; i < endH; i++) {
            timesInBetween.push(i < 10 ? "0" + i + ":00" : i + ":00");
            timesInBetween.push(i < 10 ? "0" + i + ":30" : i + ":30");
            }

            timesInBetween.push(endH + ":00");
            if (endM_new == 30)
            timesInBetween.push(endH + ":30")

            return timesInBetween.map(this.getGenTime);
            },
            bookSlot(){

             


                var tz = moment.tz.guess();
                var bookslot = this.availablehours[this.activeTime];
                var seelcteddate = this.selectedDate;

                var changetime = moment.tz('Arctic/Longyearbyen').toString();

            var newTZ= moment().tz("Asia/Calcutta");
            var oldTZ = moment().tz("America/New_York");
            var difference = newTZ.subtract(oldTZ, 'seconds')
            difference = difference.format("HH:mm");
            var sec= difference.split(":");
            var timeInMin = (sec[0] * 60) + sec[1];
            // console.log("timeinminute",timeInMin);
            var chageDateformat = moment(seelcteddate).format('YYYY-MM-DD');

                this.$axios.get(`/api/slot/check/${this.$route.params.id}/${bookslot}/${chageDateformat}`)
                .then(res => {

                    console.log("response",res);


                })

            var scheduleDetails= {
                'schedule_timeZone':tz,
                'schedule_selectDate':seelcteddate,
                'schedule_selectSlot':bookslot,
                'schedule_eventID':this.eventId,
                'schedule_userID':this.userId,
                'schedule_userName':this.userName,
                'schedule_duration':this.duration,
                'schedule_eventName':this.eventName,
            };


            // }tz,
            // this.$store.state.schedule_selectDate = seelcteddate,
            // this.$store.state.schedule_selectSlot = bookslot,
            // this.$store.state.schedule_eventID = this.eventId,
            // this.$store.state.schedule_userID = this.userId,
            // this.$store.state.schedule_userName = this.userName,
            // this.$store.state.schedule_duration = this.duration,
            // this.$store.state.schedule_eventName = this.eventName,

            localStorage.setItem('scheduleDetails', JSON.stringify(scheduleDetails));

            this.$router.push({ path: '/schedule/confirm/event' });

                // console.log(bookslot);
                // console.log(seelcteddate);
                // console.log(tz);
                // console.log(this.$store.state.schedule_userName);
            }

            // $router.push({ path: '/schedule/confirm' })
    },
    mounted(){

            this.$axios.get(`/api/schedule/${this.$route.params.id}`)
                .then(res => {

                    // console.log(res.data.data.eventschedule);

                   // var checktype = typeof JSON.parse(res.data.data.eventschedule.date_range);
                   
                    this.eventId = res.data.data.id;
                    this.userId = res.data.data.user_id;
                    this.userName = res.data.data.userdetails.name;
                    this.eventName = res.data.data.name;
                    this.duration = res.data.data.eventschedule.duration;
                    this.meetingDetails = res.data.data.description;
                    this.availabledatesvalue = res.data.data.eventschedule.availabledates;
                    //this.selectedDate = new Date();



                  var weekdaays = {'sunday':1,'monday':2,'tuesday':3,'wednesday':4,'thursday':5,'friday':6,'saturday':7};

                    var newval = JSON.parse(res.data.data.eventschedule.availabledates);

                    Object.keys(newval).forEach((value,index ) => {
                        if(newval[value].length==0){



                            this.weekdaysval.push(weekdaays[value]);
                        }
                    // console.log(newval[value].length);
                   
                    });

                     // console.log("newData",newval[value]);
                    // console.log( this.weekdaysval);


                     var getdaaterange = JSON.parse(res.data.data.eventschedule.date_range);
                     if(res.data.data.eventschedule.checked_type=='no_of_days'){

                        var start_date,new_startdate = new Date();
                        

                        if(res.data.data.eventschedule.created_at!=null || res.data.data.eventschedule.created_at!=''){

                            start_date =new Date(res.data.data.eventschedule.created_at);
                            new_startdate =new Date(res.data.data.eventschedule.created_at);
                        }

                        if(getdaaterange.type=='Calendar days'){

                            start_date.setDate(start_date.getDate() + parseInt(getdaaterange.dayscount));

                        var end_date_year = start_date.getFullYear();
                        var end_date_month = start_date.getMonth();
                        var end_date_day = start_date.getDate();


                            //this.selectedDate = new Date();

                            this.maxdate  = new Date(end_date_year,end_date_month,end_date_day);

                            // console.log('calendar',start_date) ;

                        }else{

                            var start_date = new Date();
                        

                        if(res.data.data.eventschedule.created_at!=null || res.data.data.eventschedule.created_at!=''){

                            start_date =new Date(res.data.data.eventschedule.created_at);
                          
                        }

                        // console.log(start_date);


                            var endDate = "", noOfDaysToAdd = parseInt(getdaaterange.dayscount), count = 0;
                            while(count < noOfDaysToAdd){
                            endDate = new Date(start_date.setDate(start_date.getDate() + 1));
                            if(endDate.getDay() != 0 && endDate.getDay() != 6){

                                // console.log(endDate.getDay());
                            //Date.getDay() gives weekday starting from 0(Sunday) to 6(Saturday)
                            count++;
                            }
                            }

                             var end_date_year= endDate.getFullYear();
                        var end_date_month = endDate.getMonth();
                        var end_date_day = endDate.getDate();

                            // console.log("startdate",start_date);
                            //this.selectedDate = new Date();

                            this.maxdate  = new Date(end_date_year,end_date_month,end_date_day);

                            // console.log("enddate",endDate);

                        }
                    }else{

                        var start_date = new Date(getdaaterange[0]);
                        var start_date_year = start_date.getFullYear();
                        var start_date_month = start_date.getMonth();
                        var start_date_day = start_date.getDate();

                        var end_date = new Date(getdaaterange[1]);
                        var end_date_year = end_date.getFullYear();
                        var end_date_month = end_date.getMonth();
                        var end_date_day = end_date.getDate();

                        this.mindate = new Date(start_date_year,start_date_month,start_date_day);
                        this.maxdate = new Date(end_date_year,end_date_month,end_date_day);



                        // console.log('false');
                    }


                    // console.log(getdaaterange);



                }).catch(() => {


                });
    }
}
</script>

<style scoped>
    #container{
        min-height: 600px;
    }
</style>