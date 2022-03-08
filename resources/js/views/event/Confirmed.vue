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
                        <div class="w-full font-medium p-5 md:p-10 flex justify-center">
                            <div class="w-full md:w-6/12">
                                <div class="text-center font-medium mb-4 text-xl">Confirmed</div>
                                <div class="text-center mb-4 font-normal">You are scheduled with {{scheduleDetails.schedule_userName }}.</div>
                                <hr>
                                <div class="flex gap-2 mt-4">
                                    <div class="w-5 h-5 mt-1 bg-red-500 rounded-full"></div>
                                    <div class="text-xl flex-1">{{scheduleDetails.schedule_eventName}}</div>
                                </div>
                                <div class="flex gap-2 mt-4">
                                    <div class="w-5 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">{{ slotDuration+', '+ newdate  }}</div>
                                </div>
                                <div class="flex gap-2 mt-4">
                                    <div class="w-5 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="">{{ scheduleDetails.schedule_timeZone  }}</div>
                                </div>
                                <div class="flex gap-2 mt-4">
                                    <div class="w-5 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                        </svg>
                                    </div>
                                    <div class="">Video conferencing details to follow.</div>
                                </div>
                                <div class="mt-4 font-normal">A calendar invitation has been sent to your email address.</div>
                                <hr class="mt-4">
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

        return{
            scheduleDetails:null,
            newdate:"",
            slotDuration:"",
        }
    },
    mounted(){

         const monthNames=["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
        ];

         const weekdaays = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

         this.scheduleDetails = JSON.parse(localStorage.getItem('scheduleDetails'));


console.log(this.scheduleDetails.schedule_selectDate);

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

    }
}
</script>

<style scoped>
    #container{
        height: 600px;
    }
</style>