<template>
    <div>
        <Navbar/>
        <div class="w-full bg-white border-t shadow-lg">
            <div class="flex gap-10 max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                <span class="py-4 text-lg">Set your availability</span>
            </div>
        </div>
        <div class="antialiased pt-5 pb-28">
            <div class="w-full text-gray-700">
                <div class="max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                   <div class="text-sm w-full">Choose a schedule below to edit or create a new one that you can apply to your event types</div>
                   <div class="w-full mt-5 font-medium">SCHEDULE</div>
                   <div class="flex mt-5 gap-4">


                       <button class="px-3 py-2 bg-white border border-gray-300 rounded flex items-center gap-2 font-medium hover:bg-sky-300 active" v-for="(item,index) in schedules" :key="index" @click="getData(item.id)" :class = "(item.id===scheduleId)?'active':'inactive'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>

                            <!-- <span v-if="item.id==scheduleId">{{ schedulename}}</span> -->
                            <span>{{ item.name}}</span>
                        </button>

                        <button class="px-3 py-2 border border-gray-500 rounded-3xl flex items-center gap-2" @click="$refs.newmodalName.openModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            New schedule
                        </button>
                   </div>
                </div>
            </div>
            <div class="w-full text-gray-700 mt-5">
                <div class="max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                    <div class="border bg-white rounded py-5">
                        <div class="flex justify-between px-5 pb-5">
                            <div>
                                <div class="font-medium">{{ schedulename }}</div>
                                <div class="text-sm flex items-center gap-1" v-if="is_default==0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span>default schedule</span>
                                </div>
                            </div>

                            <div>
                            <div class="flex text-sm text-blue-500 gap-3">
                                <a href="javascript:void(0)" @click="$refs.modalName.openModal()">Edit</a>


                                <a  href="javascript:void(0)" @click="showDiv('default');">Default</a>


                                <a v-if="is_default==1" href="javascript:void(0)" @click="$refs.deleteModal.openModal()">Delete</a>
                                <!--<a href="javascript:void(0)" @click="showDiv('calendar');" >Calendar View</a>-->
                            </div>

                             <div class="flex viewbuttons gap-2 mt-5">
                                    

                                    <button class="" type="button" @click="showDiv('default')"><i class="fas fa-list"></i> List view </button>
                                    <button class="" type="button" @click="showDiv('calendar')"><i class="fas fa-calendar"></i> Calendar view </button>

                                </div>
                            </div>
                            
                        </div>

                        <hr>
                        <div v-if="showmaindiv" class="px-5 pt-5 w-full">
                            <div class="font-medium">Set your weekly hours</div>
                            <div class="mt-5 w-full md:w-6/12 divide-y">
                                <div v-for="(item, i) in Object.keys(availability)" :key="i" class="flex flex-col md:flex-row text-sm gap-4 py-4 w-full ">
                                    <div class="my-3 flex-1">
                                        <div class="flex items-center gap-2" style="margin-top: 8px; width: 120px;">
                                            <input type="checkbox" class="cursor-pointer" 
                                            :id="item"  
                                            @click='check(item,$event)'
                                            v-model="availability[item].length>0?true:false"
                                            :checked="availability[item].length>0"
                                            >
                                            <span class="font-medium">{{ item.toUpperCase() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-1 gap-2 justify-between" v-if="availability[item].length>0">
                                        <div>
                                            <div v-for="(sch, i) in availability[item]" :key="i">
                                                <div class="flex gap-2 my-2 items-center" style="width:500px; margin-left: 40px;">
                                                    <vue-timepicker v-model="sch.open" input-class="rounded outline-none" format="hh:mm a"></vue-timepicker>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    <vue-timepicker v-model="sch.close" input-class="rounded outline-none" format="hh:mm a"></vue-timepicker>


                                                    <a href="javascript:void(0);" @click="removeSundayvalue(item,i)"><i class="fa-solid fa-trash-can" style="margin-left: 10px;"></i></a>

                                                <div class="timediv">
                                                <a
                                                href="javascript:void(0);"
                                                @click="
                                                addSundayvalue(
                                                item,i
                                                )
                                                "
                                                v-show="
                                                i == 0

                                                "
                                                >
                                                <i class="fa fa-plus"></i>
                                                </a>
                                                <div class="showdivicon"  v-show="
                                                i == 0

                                                ">
                                                <a
                                                href="javascript:void(0);"
                                                @click="showDropdown(item,$event)"
                                                >
                                                <i class="fa-regular fa-copy"></i>
                                                </a>
                                                    <div  class="multiselect" v-if="selectedValues[item][0].show">
                                            <ul class="px-2 py-2 bcolor" style="text-align: left;">
                                            <li class="px-1 py-1"><p>Copy Items to</p></li>
                                            <li
                                            class="px-1 py-1 dissty"
                                            v-for="(option, index) in options"
                                            :key="index"
                                            >

                                            <label :for="index">{{ option.value.charAt(0).toUpperCase() + option.value.slice(1)  }}

                                                 <input style="float: right;"
                                            class="inputstyle"
                                            type="checkbox"
                                            :id="index"
                                            :value="option.value"
                                            :checked="selectedValues[item][0].selectedvalue.includes(option.value)"
                                            :disabled="option.value==item"
                                            @click="onCheck(option.value,$event,item)"
                                            />

                                            </label>
                                           

                                            </li>

                                            <li class="px-1 py-1 butsty">
                                            <button class="applybtn" @click="onApply(item)">Apply</button>
                                            </li>
                                            </ul>
                                            </div>

                                       


                                        </div>
                                        </div>
                                                

                                                </div>

                                

                                            </div>


                                              
                                        </div>
                                    </div>

                                    <div class="flex flex-1 gap-2 justify-between" v-if="availability[item].length==0">
                                        <div>
                                            <div >
                                                <div class="flex gap-2 my-2 items-center" >
                                                    <p style="margin-right:130px">Unavailable</p>

                                                <div class="timediv">
                                                <a
                                                
                                                href="javascript:void(0);"
                                                @click="
                                                addSundayvalue(
                                                item,0
                                                )
                                                "
                                               
                                                >
                                                <i class="fa fa-plus"></i>
                                                </a>
                                                 <a
                                                href="javascript:void(0);"
                                                @click="showDropdown(item,$event)"
                                                >
                                                <i class="fa-regular fa-copy"></i>
                                                </a>
                                                        <div  class="multiselect" v-if="selectedValues[item][0].show">
                                            <ul class="px-2 py-2 bcolor">
                                            <li class="px-1 py-1"><p>Copy Items to</p></li>
                                            <li
                                            class="px-1 py-1 dissty"
                                            v-for="(option, index) in options"
                                            :key="index"
                                            >

                                            <label :for="index">{{ option.value.charAt(0).toUpperCase() + option.value.slice(1)  }}</label>
                                            <input
                                            class="inputstyle"
                                            type="checkbox"
                                            :id="index"
                                            :value="option.value"
                                            :checked="selectedValues[item][0].selectedvalue.includes(option.value)"
                                            @click="onCheck(option.value,$event,item)"
                                            />

                                            </li>

                                            <li class="px-1 py-1 butsty">
                                            <button class="applybtn" @click="onApply(item)">Apply</button>
                                            </li>
                                            </ul>
                                            </div>
                                        
                                               
                                   

                                                
                                        </div>

                                                

                                                </div>
                                        

                                            </div>



                                            </div>


                                              
                                        </div>
                                    </div>
                                      
                                  
                                </div>
                            </div>

                              <div v-if="showdiv" class="px-5 pt-5 w-full">

                            <CalendarView :availabledata="availability"></CalendarView>

                           
                            
                            

                        </div>
                       
 <!-- Modal -->




                            <div class="px-5 py-5">
                                <button @click="saveSchedule()" class="bg-blue-500 text-white px-5 py-1 rounded">Save</button>
                            </div>
                        </div>
                        <!-- Modal -->



                    </div>

                    <!-- Edit Modal -->
    <modal ref="modalName">
      <template v-slot:header>
        <h1>Edit Schedule Name</h1>
      </template>

      <template v-slot:body>
         <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
       Schedule Name
      </label>
      <input v-model="schedule_name" type="text" name="schedule_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Working Hours,Exclusive Hours..">
    </div>
        
      </template>

      <template v-slot:footer>
        <div>
          <button @click="$refs.modalName.closeModal()" class="text-black px-5 py-1 rounded" style="background-color:#e8e9e9;">Cancel</button>
          <button @click="saveScheduleName('edit')" style="float:right" class="bg-blue-500 text-white px-5 py-1 rounded">Save</button>
        </div>
      </template>
    </modal>
<!-- edit modal end -->

<!-- create modal-->
    <modal ref="newmodalName">
      <template v-slot:header>
        <h1>New Schedule</h1>
      </template>

      <template v-slot:body>
         <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
       Schedule Name
      </label>
      <input v-model="new_schedule_name" type="text" name="new_schedule_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Working Hours,Exclusive Hours..">
    </div>
        
      </template>

      <template v-slot:footer>
        <div>
          <button @click="$refs.newmodalName.closeModal()" class="text-black px-5 py-1 rounded" style="background-color:#e8e9e9;">Cancel</button>
          <button @click="saveScheduleName('new')" style="float:right" class="bg-blue-500 text-white px-5 py-1 rounded">Create</button>
        </div>
      </template>
    </modal>
    <!--create modal end-->

    <!--delete modal-->
          <modal ref="deleteModal">
      <template v-slot:header>
        <h1>Delete Schedule</h1>
      </template>

      <template v-slot:body>
         <div class="mb-4">
      
      <p class="text-lg">Are you sure that you want to delete this schedule?</p>
     
    </div>
        
      </template>

      <template v-slot:footer>
        <div>
          <button @click="$refs.deleteModal.closeModal()" class="text-black px-5 py-1 rounded" style="background-color:#e8e9e9;">Cancel</button>
          <button @click="deleteSchedule()" style="float:right" class="bg-red-500 text-white px-5 py-1 rounded">Delete</button>
        </div>
      </template>
    </modal>

    <!--delete modal end-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from '../../components/Navbar.vue'
import Modal from "../../components/Modal";
import VueTimepicker from 'vue2-timepicker'
import CalendarView from '../../components/CalendarView.vue'
import 'vue2-timepicker/dist/VueTimepicker.css'


export default {
    data(){
        return { 
            events: null,
            showModal: false,
            schedulename:"",
            schedule_name:"",
            new_schedule_name:"",
            scheduleId:null,
            //isActive:false,
            isCheck:false,
            show:false,
            showdiv:false,
            showmaindiv:true,
            events:[],
            schedules:null,
            is_default:1,
            availability: {
                sunday: [
                    {
                        open: '',
                        close: '',
                    }
                ],
                monday: [
                    {
                        open: '',
                        close: '',
                    }
                ],
                tuesday: [
                    {
                        open: '',
                        close: '',
                    }
                ],
                wednesday: [
                    {
                        open: '',
                        close: '',
                    }
                ],
                thursday: [
                    {
                        open: '',
                        close: '',
                    }
                ],
                friday: [
                    {
                        open: '',
                        close: '',
                    },
                ],
                saturday: [
                    {
                        open: '',
                        close: '',
                    }
                ]
            },
            selectedValues: { 
            sunday:[

               { 
                show:false,
                isCheck:false,
                selectedvalue:
                [
                    "sunday"
                ],

                }
                    
            ],
              monday:[

              {
                
                 show:false,
                 isCheck:false,
                selectedvalue:
                [
                    "monday"
                ] 
                }
            ],
            tuesday:[
                {
                
                show:false,
                isCheck:false,
                selectedvalue:
                [
                    "tuesday"
                ] 
                }
            ],
            wednesday:[
               {
                
                 show:false,
                 isCheck:false,
                selectedvalue:
                [
                    "wednesday"
                ] 
                }
            ],
            thursday:[
               {
                
                 show:false,
                 isCheck:false,
                selectedvalue:
                [
                    "thursday"
                ] 
                }
            ],
            friday:[
                {
                 show:false,
                 isCheck:false,
                selectedvalue:
                [
                    "friday"
                ] 
                }
            ],
            
            saturday:[
                {
                 show:false,
                 isCheck:false,
                selectedvalue:
                [
                    "saturday"
                ] 
                }
            ]
            },
             options: [
                {
                    text:'SUN',
                    value:'sunday',
                },
                {
                    text:'MON',
                    value:'monday',
                },
                {
                    text:'TUE',
                    value:'tuesday',
                },
                {
                    text:'WED',
                    value:'wednesday',
                },
                {
                    text:'THU',
                    value:'thursday',
                },
                {
                    text:'FRI',
                    value:'friday',
                },
                {
                    text:'SAT',
                    value:'saturday',
                }
            ],
     
        }
    },
    components: {
        Navbar,
        VueTimepicker,
        CalendarView,
        Modal,
      
    },
    methods: {
        saveSchedule(){

            console.log(this.availability);
            this.$axios.post('/api/schedule', {
                // availability: JSON.stringify(this.availability)
                availability: this.availability,
                schedule_id: this.scheduleId,
            }).then((res) => {

                console.log(res);
                 this.$dtoast.pop({
                    preset: "success",
                    heading: `Success!`,
                    content: `Working hours added!`,
                });
            }).catch(() => {
                
                this.$dtoast.pop({
                    preset: "error",
                    heading: `Error!`,
                    content: `Something when wrong, please try again!`,
                });
            });
        },

         addSundayvalue(index,intervalindex) {

            //console.log(index+'--'+intervalindex);
            // let item=index;
             console.log(index);

            //console.log(this.availability.item);
            const prevData=this.availability[index].slice(-1)[0];

            console.log(prevData);
            let prev_start_time="";
            let prev_end_time="";

            if(!prevData){
                    prev_start_time="09:00 am";
                    prev_end_time="11:00 am";

            }else{

                    prev_start_time=prevData['open'];
                    prev_end_time=prevData['close'];
            }


            this.availability[index].push({
                open: prev_start_time,
                close: prev_end_time,

            });
        },
          removeSundayvalue(index,intervalindex) {

            //console.log(this.availability[index]);
            this.availability[index].splice(intervalindex, 1);
            this.isCheck = false;
        },
         check(index,event) {

            this.selectedValues[index][0].isCheck = !this.selectedValues[index][0].isCheck;

            if(event.target.checked){

                if(!this.availability[index] || this.availability[index].length<1)
                {
                        this.availability[index].push({
                        open: "09:00",
                        close: "11:00",

                        });
                }


            }else{

                this.availability[index].splice(0, this.availability[index].length);
            }

        },
          showDropdown(index,event) {

        this.selectedValues[index][0].show = !this.selectedValues[index][0].show;
        console.log(this.selectedValues[index]);

        },
          onCheck(val,event,item) {

            var selectedindex;

            if(event.target.checked){
                //console.log('checked');
                 this.selectedValues[item][0].selectedvalue.push(val);


            }else{
                 //console.log('unchecked');
                this.selectedValues[item][0].selectedvalue.splice(this.selectedValues[item][0].selectedvalue.indexOf(val), 1);

            }
        console.log(this.selectedValues[item]);
        },
          onApply(indexval){

            //console.log(indexval);
             //console.log(this.availableDates);
            this.selectedValues[indexval][0].show = false;


           this.selectedValues[indexval][0].selectedvalue.forEach((value,index )=>{

            if(indexval!=value){

                this.availability[value]=this.availability[indexval].slice();
            }


           });

       },
       showDiv(type){

        //alert();
        if(type=='default'){

           
            this.showdiv = false;
            this.showmaindiv = true;
        }
        if(type=='calendar'){

            this.showdiv = true;
            this.showmaindiv = false;

            
        }
        

       },
        handleDateClick: function(arg) {
      alert('date click! ' + arg.dateStr)
    },
    saveScheduleName(type){
        console.log(this.schedulename);
        console.log(this.scheduleId);

        if(type=='edit'){

            var scheduleName = this.schedule_name;
        }else{

            var scheduleName = this.new_schedule_name;
        }

        var postData = {

            'scheduleid':this.scheduleId,
            'schedulename':scheduleName,
            'type':type,
        }

          this.$axios.post(`/api/schedule/update`,postData).then( res => {

            //console.log(res.data);
            // this.availability = JSON.parse(res.data.data.availability);

            if(res.data.success==true){

                if(type=='edit'){
                     this.schedulename = res.data.data.name;
    
            this.$dtoast.pop({
                        preset: "success",
                        heading: `Success!`,
                        content: `Schedule Name Changed`,
                     });

            this.$refs.modalName.closeModal();

             setTimeout(function () {
                     window.location.reload();
                 }, 1000);
        }else{
           
            this.$dtoast.pop({
                        preset: "success",
                        heading: `Success!`,
                        content: `New Schedule Created`,
                     });

            this.$refs.newmodalName.closeModal();

            setTimeout(function () {
                     window.location.reload();
                 }, 1000);

        }

        

           
            }else{

                if(type=='edit'){

                    this.$refs.modalName.closeModal();

                        this.$dtoast.pop({
                        preset: "error",
                        heading: `Error!`,
                        content: `Name already exists.`,
                    });

                }else{

                    this.$refs.newmodalName.closeModal();

                    this.$dtoast.pop({
                        preset: "error",
                        heading: `Error!`,
                        content: `Something went wrong.`,
                    });
                }

                
                 
            }



            // this.schedule_name = res.data.data.name;
            // this.scheduleId = res.data.data.id;
            //this.events = res.data.data
        })

    //this.show = false;
      //document.querySelector("body").classList.remove("overflow-hidden");
    },

    getData(sheduleid){

        //this.availability = null;

          this.$axios.get(`/api/schedule/getIndividual/${sheduleid}`).then( res => {

            console.log(res.data.data);

            //this.schedules = res.data.data;

            this.availability = JSON.parse(res.data.data.availability);
            this.schedulename = res.data.data.name;
            this.schedule_name = res.data.data.name;
            this.scheduleId = res.data.data.id;
            this.is_default = res.data.data.is_default;
            //this.events = res.data.data
        })
    },

    deleteSchedule(){

        //sheduleid = this.scheduleId;
         this.$axios.delete(`/api/schedule/delete/${this.scheduleId}`).then( res => {

            if(res.data.success==true){

                this.$refs.deleteModal.closeModal();

                 this.$dtoast.pop({
                        preset: "success",
                        heading: `Success!`,
                        content: `Schedule Deleted successfully`,
                     });

                  setTimeout(function () {
                     window.location.reload();
                 }, 1000);


            }else{

                 this.$refs.deleteModal.closeModal();
                  this.$dtoast.pop({
                        preset: "error",
                        heading: `Error!`,
                        content: `Something went wrong.`,
                    });




            }

            // console.log(res.data.data);

            // //this.schedules = res.data.data;

            // this.availability = JSON.parse(res.data.data.availability);
            // this.schedulename = res.data.data.name;
            // this.schedule_name = res.data.data.name;
            // this.scheduleId = res.data.data.id;
            //this.events = res.data.data
        })


    }


    },
    mounted() {
        this.$axios.get(`/api/schedule`).then( res => {

            console.log(res.data.data);

            this.schedules = res.data.data;

            this.availability = JSON.parse(res.data.data[0].availability);
            this.schedulename = res.data.data[0].name;
            this.schedule_name = res.data.data[0].name;
            this.scheduleId = res.data.data[0].id;
            this.is_default = res.data.data[0].is_default;
            //this.isActive = true;
            //this.events = res.data.data
        })
    },
}
</script>

<style scoped>
    <style lang="scss">
.overflow-hidden {
  overflow: hidden;
}
    .mx-datepicker-range {
        width: 100% !important;
    }

    .active{

        background-color: #c1edff;
    }
    .inactive{
        background-color: unset;   
    }


</style>