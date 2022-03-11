<template>
    <div>
        <Navbar/>
        <div class="w-full bg-white border-t shadow-lg">
            <div class="flex gap-10 max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                <a href="javascript:void(0)" class="hover:border-gray-300 border-b-4 py-4" @click="openTab('event_types')" v-bind:class="[eventtypes ? 'border-blue-500' : 'border-white']">Event Types</a>
                <a href="javascript:void(0)" class="hover:border-gray-300 border-blue-500 border-b-4 py-4" @click="openTab('schedule_event')" v-bind:class="[scheduleevents ? 'border-blue-500' : 'border-white']">Scheduled Events</a>
            </div>
        </div>
        <div class="antialiased pt-5 pb-28" v-show="eventtypes">
            <div class="w-full text-gray-700 dark-mode:text-gray-200 dark-mode:bg-gray-800">
                <div class="max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    <input type="text" placeholder="Filter" class="bg-gray-50 outline-none flex-1">
                </div>
                <div class="max-w-screen-lg mt-4 px-4 mx-auto md:px-6 lg:px-8">
                    <div class="border-b-2 py-4 flex justify-between gap-2">
                        <div class="flex items-center gap-2 text-sm">
                            <div>
                                <div class="w-10 h-10 bg-blue-500 font-medium text-xl rounded-full flex justify-center text-white items-center">
                                    {{ (userName == null) ? '' : userName.charAt(0) }}
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div>{{ userName }}</div>
                                <div class="text-blue-500">example.com/{{ userName }}</div>
                            </div>
                        </div>
                        <div>
                            <button @click="$router.push('/create')" class="flex gap-2 border items-center border-blue-500 text-blue-500 py-1 px-3 rounded-3xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Create new event</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="max-w-screen-lg mt-4 px-4 mx-auto md:px-6 lg:px-8 grid grid-cols-3 gap-4">
                    <div v-for="event in events" :key="event.id" class="shadow rounded border-t-8 mb-3 hover:shadow-lg hover:scale-105 hover:cursor-pointer" :style="`border-color:${event.color}`">
                        <div class="p-4 h-44">
                            <div @click="goToShowEvent(event.id)" class="font-medium text-lg hover:text-gray-400">{{ event.name }}</div>
                            <div class="text-sm py-2 truncate" v-html="event.description"></div>
                            <a class="text-sm my-2 cursor-pointer text-blue-500 hover:border-b border-blue-500">view booking page</a>
                        </div>
                        <div class="p-4 flex border-t">
                            <div class="flex text-sm text-blue-500 items-center cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Copy Link</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="antialiased pt-5 pb-28" v-show="scheduleevents">
            <div class="w-full">
                <div class="max-w-screen-lg mt-4 mx-auto shadow-md">

                    <div class="w-full bg-white border-t shadow-lg">
                    <div class="flex gap-10 max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                    <a href="javascript:void(0)" class="hover:border-gray-300 border-b-4 py-4" @click="openTab2('upcoming')" v-bind:class="[upcoming ? 'border-blue-500' : 'border-white']">Upcoming</a>
                    <a href="javascript:void(0)" class="hover:border-gray-300 border-blue-500 border-b-4 py-4" @click="openTab2('past')" v-bind:class="[past ? 'border-blue-500' : 'border-white']">Past</a>
                      <a href="javascript:void(0)" class="hover:border-gray-300 border-blue-500 border-b-4 py-4" @click="openTab2('daterange')" v-bind:class="[daterange ? 'border-blue-500' : 'border-white']">Date Range</a>

                    </div>
                    </div>

                    <div >
                        

                    </div>

                    <div class="w-full bg-white" v-if="preLoader==false">

                        
                       <p v-if="dateRange!=null" class="px-2 py-4"><b>{{getdaterangeFormat()}}</b></p>
                        <div v-if="Object.keys(scheduleDetails).length>0" class="w-full" v-for="i in Object.keys(scheduleDetails)" :key="i">

                            <div v-show="new Date(i)>new Date()">
                                <div class="w-full bg-gray-200 px-8 py-4">
                                
                                <p>{{ getdateFormat(i) }}</p>
                               

                                </div>
                                <div class="w-full bg-white px-8 py-4" v-for="(item,index) in scheduleDetails[i]">

                                    <div class="flex w-full">
                                        
                                        <div class="w-2/6 gap-2">
                                            <div class="flex">
                                            <div class="roundshape" v-bind:style="{ 'background-color': item.event.color}"></div>
                                            <p class="px-1">{{ item.slot }}</p>
                                            </div>
                                
                                 <p style="margin-left: 42px;">{{item.timezone}}</p>
                                </div>
                                <div class="w-2/6">
                                <p><b>{{ item.name }}</b></p>
                                 <p>{{item.email}}</p>
                                <p>{{item.event.name}}</p>
                               
                                </div>
                                <div class="w-2/6">
                                <p>Action</p>
                                </div>


                                    </div>

                                </div>

                            </div>

    
                        
                            


                        </div>
                        <div v-if="Object.keys(scheduleDetails).length==0" class="w-full bg-white px-8 py-4 h-3/4">
                            <p class="text-center"> No Data Found </p>
                        </div>



                    </div>

<div class="border border-blue-300 shadow rounded-md p-4 py-4 max-w-sm w-full mx-auto m-20" v-if="preLoader==true">
<div class="animate-pulse flex space-x-4">
<div class="rounded-full bg-slate-200 h-10 w-10"></div>
<div class="flex-1 space-y-6 py-1">
<div class="h-2 bg-slate-200 rounded"></div>
<div class="space-y-3">
<div class="grid grid-cols-3 gap-4">
<div class="h-2 bg-slate-200 rounded col-span-2"></div>
<div class="h-2 bg-slate-200 rounded col-span-1"></div>
</div>
<div class="h-2 bg-slate-200 rounded"></div>
</div>
</div>
</div>
</div>
<!-- 
                     <div class="w-full bg-white" v-show="past">
                        <div class="w-full" v-for="i in Object.keys(scheduleDetails)" :key="i">

                            <div v-show="new Date(i)<new Date()">
                                <div class="w-full bg-gray-200 px-8 py-4">
                                <p>{{ getdateFormat(i) }}</p>

                                </div>
                                <div class="flex w-full bg-white px-8 py-4" v-for="(item,index) in scheduleDetails[i]">

                                <div class=" flex w-2/6 gap-2">
                                <div class="roundshape" v-bind:style="{ 'background-color': item.event.color}"></div>
                                <p>{{ item.slot }}</p>
                                </div>
                                <div class="w-2/6">
                                <p><b>{{ item.name }}</b></p>
                                <p>{{item.event.name}}</p>
                                </div>
                                <div class="w-2/6">
                                <p>Action</p>
                                </div>

                                </div>

                            </div>
                        
                            


                        </div>
                    </div> -->
                </div>

              
            </div>
        </div>


        <!-- Edit Modal -->
    <modal ref="modalName">
        <template v-slot:header>
        <h1>Search By date range</h1>
        </template>

        <template v-slot:body>
        <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
        Date Range
        </label>
        <date-picker  
        v-model="dateRange" ref="datepicker" type="date" range placeholder="Select date range"
        ></date-picker>
        
        </div>

        </template>

        <template v-slot:footer>
        <div>
        <button @click="$refs.modalName.closeModal()" class="text-black px-5 py-1 rounded" style="background-color:#e8e9e9;">Cancel</button>
        <button @click="getscheduleByDateRange()" style="float:right" class="bg-blue-500 text-white px-5 py-1 rounded">Apply</button>
        </div>
        </template>
    </modal>
<!-- edit modal end -->
    </div>
</template>

<script>
import Navbar from '../../components/Navbar.vue'
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import Modal from "../../components/Modal";
import moment from "moment";

export default {
    data(){
        return {
            preLoader:true,
            dateRange: null,
            upcoming:true,
            past:false,
            daterange:false,
            eventtypes:true,
            scheduleevents:false,
            events: null,
            userName: null,

            scheduleDetails:{},
        }
    },
    components: {
        Navbar,
        Modal
    },
    methods: {
        goToShowEvent(eventId) {
            this.$router.push(`/event/show/${eventId}`);
        },
        openTab(tabType){

            if(tabType=='event_types'){
                this.eventtypes = true;
                this.scheduleevents = false;
               

            }else{
                var type = 'upcoming';
                this.$axios.get(`/api/event-schedule-list/${type}`).then( res => {
               // console.log(res);

                this.scheduleDetails = res.data.data;

                console.log(this.scheduleDetails);
                this.eventtypes = false;
                this.scheduleevents = true;
                this.upcoming = true;

                this.preLoader = false;



                })



               

            }

           
        },
        openTab2(tabType){

             if(tabType=='upcoming'){

                this.upcoming = true;
                this.past = false;
                 this.daterange = false;
                 var type = 'upcoming';

                  this.$axios.get(`/api/event-schedule-list/${type}`).then( res => {
               // console.log(res);

                this.scheduleDetails = res.data.data;

                console.log(this.scheduleDetails);
                this.eventtypes = false;
                this.scheduleevents = true;
                this.upcoming = true;

                this.preLoader = false;



                })

            }else if(tabType=='past'){

                this.preLoader = true;

                this.past = true;
                this.upcoming = false;
                this.daterange = false;
                var type = 'past';
                this.$axios.get(`/api/event-schedule-list/${type}`).then( res => {
                console.log(res);

                this.scheduleDetails = res.data.data;

                console.log(this.scheduleDetails);
                this.eventtypes = false;
                this.scheduleevents = true;
               

                this.preLoader = false;



                })

            }else if(tabType=='daterange'){

                 this.past = false;
                this.upcoming = false;
                this.daterange = true;
                this.$refs.modalName.openModal()

            }


        },
        getdateFormat(selectdate){

            const monthNames=["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ];

            const weekdaays = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

             var month = new Date(selectdate).getMonth();
            var monthname = monthNames[month];

            var day = new Date(selectdate).getDay();
            var dayname = weekdaays[day];

            var date = new Date(selectdate).getDate();
            var year = new Date(selectdate).getFullYear();

            var newdate = dayname+', '+monthname+' '+date+', '+year;

            return newdate;
            },
            getscheduleByDateRange(){


                this.preLoader = true;

                    console.log(this.dateRange);
                    this.$refs.modalName.closeModal();
                    var start_date=moment(this.dateRange[0]).format('YYYY-MM-DD');
                    var end_date=moment(this.dateRange[1]).format('YYYY-MM-DD');

                   // console.log($startdate);
                    //console.log($enddate);
                     var type = 'daterange';

                    this.$axios.get(`/api/event-schedule-list`,{ params: { type: 'daterange',startdate: start_date,enddate:end_date  }}).then( res => {
                     console.log("range",res);

                    this.scheduleDetails = res.data.data;

                    console.log(this.scheduleDetails);
                    this.eventtypes = false;
                    this.scheduleevents = true;

                    this.preLoader = false;
                    // this.upcoming = true;



                    })




            },
            getdaterangeFormat(){

                if(this.dateRange!=null){

                              const monthNames=["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ];

            const weekdaays = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

             var start_month = new Date(this.dateRange[0]).getMonth();
            var start_monthname = monthNames[start_month];

            var start_day = new Date(this.dateRange[0]).getDay();
            var start_dayname = weekdaays[start_day];

            var start_date = new Date(this.dateRange[0]).getDate();
            var start_year = new Date(this.dateRange[0]).getFullYear();

             var end_month = new Date(this.dateRange[1]).getMonth();
            var end_monthname = monthNames[end_month];

            var end_day = new Date(this.dateRange[1]).getDay();
            var end_dayname = weekdaays[end_day];

            var end_date = new Date(this.dateRange[1]).getDate();
            var end_year = new Date(this.dateRange[1]).getFullYear();

            var newdate = start_date+' '+start_monthname+' '+start_year+' - '+end_date+' '+end_monthname+' '+end_year;

            return newdate;
                }

           


            }

           
    },
    mounted() {
        var userData = JSON.parse(localStorage.getItem('auth-user'));
        this.userName = userData.name;
        this.$axios.get(`/api/events`).then( res => {
            this.events = res.data.data
        })
    },
}
</script>

<style scoped>
    .mx-datepicker-range {
        width: 100% !important;
    }
    .roundshape{
            width: 40px;
            height: 40px;
            border-radius: 50%;
    }
</style>
