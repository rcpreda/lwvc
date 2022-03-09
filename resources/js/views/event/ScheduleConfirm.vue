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
                        <div class="w-full md:w-4/12 font-medium border-r p-5 md:p-10">
                            <div class="rounded-full h-10 w-10 hover:bg-blue-100 flex items-center justify-center border cursor-pointer" @click="$router.go(-1)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />

                                </svg>
                            </div>
                            <div class="text-gray-500 mt-4">{{ scheduleDetails.schedule_userName }}</div>
                            <div class="text-xl md:text-2xl font-bold text-gray-700">{{scheduleDetails.schedule_eventName}}</div>
                            <div class="flex items-center gap-2 text-gray-700 mt-4">
                                <div class="w-5">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">{{scheduleDetails.schedule_duration}}</div>
                            </div>
                            <div class="flex items-start gap-2 text-gray-700 mt-4">
                                <div class="w-5 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                    </svg>
                                </div>
                                <div class="flex-1">Video conferencing details provided upon confirmation.</div>
                            </div>
                            <div class="flex items-start gap-2 text-gray-700 mt-4">
                                <div class="w-5 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">{{ slotDuration+', '+ newdate  }}</div>
                            </div>
                            <div class="flex items-start gap-2 text-gray-700 mt-4">
                                <div class="w-5 mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">{{ scheduleDetails.schedule_timeZone  }}</div>
                            </div>
                        </div>
                        <div class="w-full md:w-8/12 font-medium p-5 md:p-10">
                            <div class="w-full md:w-8/12">
                                <div class="text-xl">Enter Details</div>
                                <div class="mt-4">
                                    <label for="name">Name *</label>
                                    <input type="text" v-model="invitee_name" class="border py-2 px-2 w-full mt-2 rounded-md">
                                    <small class="text-red-500 mx-2" v-show="validationErrorMessages.invitee_name !== null">{{ validationErrorMessages.invitee_name }}</small>
                                </div>
                                <div class="mt-4">
                                    <label for="name">Email *</label>
                                    <input type="text" v-model="invitee_email" class="border py-2 px-2 w-full mt-2 rounded-md">
                                    <small class="text-red-500 mx-2" v-show="validationErrorMessages.invitee_email !== null">{{ validationErrorMessages.invitee_email }}</small>
                                </div>
                                <div class="mt-4">
                                    <label for="name">Please share anything that will help prepare for our meeting.</label>
                                    <textarea v-model="invitee_description" class="border py-2 px-2 w-full mt-2 rounded-md"></textarea>
                                    <small class="text-red-500 mx-2" v-show="validationErrorMessages.invitee_description !== null">{{ validationErrorMessages.invitee_description }}</small>
                                </div>
                                <div class="mt-4">
                                    <button @click="bookslot()" class="py-2 px-3 bg-blue-600 text-white rounded-3xl">Schedule Event</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
export default {
    data(){
        return {
           scheduleDetails:{},
           newdate:"",
           eventName:"",
           slotDuration:"",
           user_id:"",
           event_id:"",
           confirmDate:"",
           timezone:"",
           invitee_name:"",
           invitee_email:"",
           invitee_description:"",
            validationErrorMessages: {
                    invitee_name: null,
                    invitee_email: null,
                    invitee_description:null
                   
                },
        }
    },
    computed: {


       
    },

    methods: {

        bookslot(){

            var processSave = true;


            if(this.invitee_name==""){

                processSave = false;

                this.validationErrorMessages.invitee_name = "Name is required";
            }else{

                this.validationErrorMessages.invitee_name=null;
            }


             if(this.invitee_email==""){
                processSave = false;

                this.validationErrorMessages.invitee_email = "Email is required";
            }else{

                this.validationErrorMessages.invitee_email=null;
            }

             if(this.invitee_description==""){
                processSave = false;

                this.validationErrorMessages.invitee_description = "Description about meeting is required";
            }else{

                this.validationErrorMessages.invitee_description=null;
            }


            if(processSave == true){


              this.$axios.post('/api/schedule/slot-confirm', {
                // availability: JSON.stringify(this.availability)
                name: this.invitee_name,
                email: this.invitee_email,
                description: this.invitee_description,
                slot:this.slotDuration,
                date:this.confirmDate,
                userId:this.user_id,
                eventid:this.event_id,
                timeZone:this.timezone,
                newdateval:this.newdate,
                eventname:this.eventName,
            }).then((res) => {

                // console.log(res);
                 this.$dtoast.pop({
                    preset: "success",
                    heading: `Success!`,
                    content: `Slot confirm for this schedule`,
                });

                 this.$router.push({ path: '/schedule/confirmation/event' })
            }).catch(() => {
                
                this.$dtoast.pop({
                    preset: "error",
                    heading: `Error!`,
                    content: `Something when wrong, please try again!`,
                });
            });


            }


            
            

        }
        
    },
    mounted(){

        const monthNames=["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
        ];

         const weekdaays = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

         this.scheduleDetails = JSON.parse(localStorage.getItem('scheduleDetails'));


// console.log(this.scheduleDetails.schedule_selectDate);

         var month = new Date(this.scheduleDetails.schedule_selectDate).getMonth();
         var monthname = monthNames[month];

         var day = new Date(this.scheduleDetails.schedule_selectDate).getDay();
         var dayname = weekdaays[day];

         var date = new Date(this.scheduleDetails.schedule_selectDate).getDate();
         var year = new Date(this.scheduleDetails.schedule_selectDate).getFullYear();

         this.newdate = dayname+', '+monthname+' '+date+', '+year;

         var duration = parseInt(this.scheduleDetails.schedule_duration.split(" ")[0]);
         var time = parseInt(this.scheduleDetails.schedule_selectSlot.split(" ")[0]);

         if(month<10){
            var monthwith = "0"+month;
         }else{
            var monthwith = month;
         }

         var newdaate = year+'-'+monthwith+'-'+date;



         var getdate = new Date(newdaate+' '+this.scheduleDetails.schedule_selectSlot);

          var newduration = moment(getdate).add(15, 'minutes').format('hh:mm A');

          this.slotDuration = this.scheduleDetails.schedule_selectSlot+'-'+newduration;

          this.user_id = this.scheduleDetails.schedule_userID;
          this.event_id = this.scheduleDetails.schedule_eventID;
          this.confirmDate = moment(this.scheduleDetails.schedule_selectDate).format('YYYY-MM-DD');
          this.timezone = this.scheduleDetails.schedule_timeZone;

          this.eventName = this.scheduleDetails.schedule_eventName;
         
         // console.log(newduration);

        
    }
}
</script>

<style scoped>
    #container{
        min-height: 600px;
    }
</style>