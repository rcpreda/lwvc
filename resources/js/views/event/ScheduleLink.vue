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
                <div class="max-w-screen-lg p-8 mx-auto items-center justify-between">
                    <div id="container" class="w-full border rounded-md bg-white justify-center">

                        <div class="w-full justify-center text-center font-medium border-r p-5" >
                            <div class="flex flex-wrap justify-center">
                            <div class="w-4/12 sm:w-2/12 px-4">
                            <img v-if="url" :src="url" alt="..." class="rounded-full shadow-lg max-w-full align-middle border-none" />
                            </div>
                            </div>
                            <div class="text text-gray-700">{{username}}</div>
                            <div class="text text-gray-700">{{welcomemessage}}</div>
                         
                         
                            
                        </div>
                        <div class="max-w-screen-lg mt-4 px-4 mx-auto md:px-6 lg:px-8 grid grid-cols-3 gap-4">

                                <div v-for="event in events" :key="event.id" class="shadow rounded border-t-8 mb-3 hover:shadow-lg hover:scale-105 hover:cursor-pointer" :style="`border-color:${event.color}`" @click="goToEventBooking(event.fullurl)">
                        <div class="p-4 h-44">
                            <div class="font-medium text-lg hover:text-gray-400">{{ event.name }}</div>
                            <div class="text-sm py-2 truncate" v-html="event.description"></div>
                            <!-- <a v-bind:href="event.fullurl" class="text-sm my-2 cursor-pointer text-blue-500 hover:border-b border-blue-500">view booking page</a> -->
                        </div>
                        <div class="p-4 flex border-t">
                            <div class="flex text-sm text-blue-500 items-center cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span @click="copyURL(event.fullurl)" >Copy Link</span>
                            </div>
                        </div>
                    </div>
                          <!--   <div class="flex flex-row">
                           <div class="w-full md:w-4/12 font-medium border-t p-5 hover:bg-gray-100" v-for="event in events" :key="event.id">
                            
                            <div class="flex gap-2">
                                <div class="rounded-full bg-green-500" style="width:37px;height: 37px;"></div>
                                <div class="text-2xl font-bold text-gray-700">{{event.name}}</div>
                            </div>
                            
                            <div class="text-2xl font-bold text-gray-700">{{

                                strippedHtml(event.description)
                            }}</div>
                         
                         </div>
                         </div> -->
                            
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from '../../components/Navbar.vue'
// import Modal from "../../components/Modal";
// import VueTimepicker from 'vue2-timepicker'
// import CalendarView from '../../components/CalendarView.vue'
// import 'vue2-timepicker/dist/VueTimepicker.css'
// import moment from "moment";


export default {
	name:"ScheduleLink",
    data(){
        return { 
            events:{},
            url:null,
            username:null,
            welcomemessage:null,
            eventName:"test",
            eventDetails:"test",
           
        	}

        },
        methods:{
            goToEventBooking(urlval){

                window.location.href = urlval;

            },

            strippedHtml(originalString) {
           let strippedString = originalString.replace(/(<([^>]+)>)/gi, "");

           return strippedString;
            },

              async copyURL(mytext) {
        try {
        await navigator.clipboard.writeText(mytext);
             this.$dtoast.pop({
                    preset: "success",
                    heading: `Success!`,
                    content: `Link copied.`,
                });
        } catch($e) {
            this.$dtoast.pop({
                    preset: "error",
                    heading: `Error!`,
                    content: `Something when wrong, please try again!`,
                });
        }
        }

        },
        mounted(){

            console.log(this.$route.params.userid);

            this.$axios.get(`/api/schedule/${this.$route.params.userid}`)
                .then(res => {
                    console.log(res);

                    if(res.data.success==true){

                        if(res.data.data[0].profile_image == null){
                            this.url = '/storage/profileimage/defaultavatar.jpg';
                        }else{
                            this.url = '/storage/profileimage/'+res.data.data[0].profile_image;
                        }

                            
                            this.username = res.data.data[0].name;
                            this.welcomemessage = res.data.data[0].welcome_message;
                           this.events = res.data.data[0].events;

                        let vueurl = window.location.origin + this.$route.path;
                         console.log(vueurl);

                        this.events.map(function(value, key) {

                        let newurl = vueurl+value.link;                  

                        value.fullurl = newurl;
                        console.log(value);
                        });

                    }else{

                         this.$dtoast.pop({
                            preset: "error",
                            heading: `Error!`,
                            content: `Something went wrong.`,
                            });
                    }
                });
        }

    }

</script>