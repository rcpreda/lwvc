<template>
  <div class="text-center section">
    <!-- <h2 class="h2">Working Calendars</h2> -->
    <p class="text-lg font-medium text-gray-600 mb-6">
      Set your weekly hours
    </p>
    <vc-calendar
     
      class="custom-calendar  max-w-full"
      :masks="masks"  
      :attributes="attributes"
      title-position="left"
      disable-page-swipe
      is-expanded
      

    >

      <!-- <template v-slot="{ inputValue, inputEvents }">
      <input
      class="bg-white border px-2 py-1 rounded"
      :value="inputValue"
      v-on="inputEvents"
      />
      </template> -->
      <template v-slot:day-content="{ day, attributes }" >

         <div @click="dayClicked(day)" class="flex flex-col h-full z-10 overflow-hidden hover:bg-sky-100 hover:border-red-800" v-bind:class="{ 'disableclass' : new Date(day.id)<new Date((new Date()).valueOf() - 1000*60*60*24)}" style="padding: 20px;">
          <span  v-bind:class="{ 'currentdate' : day.isToday==true}" style="margin-bottom: 5px;" >{{ day.day}}</span>
           <div class="flex-grow overflow-y-auto overflow-x-auto">

            <div  v-for="(item, i) in availabledata" :key="i" style="font-size:11px;">
              <p v-if="weekdays[0][day.weekday]==i" v-for="(times, j) in availabledata[i]" :key="j">
                
                  {{moment(times.open) +'-'+moment(times.close) }}
              </p>
             

            </div>
            <!-- <p v-if="day.weekday!='3'">
               Others

            </p> -->
            <!-- <p
              v-for="attr in attributes"
              :key="attr.key"
              class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1"
              :class=""
            >
              {{ attr.customData.title }}
            </p> -->
          </div>

      
         </div>
        <!--  <div v-if="isClicked==day.day" :id="day.id" class="showdate">
  <div class="flex mb-2 ">
    <label class="text-gray-600 font-medium">Select the date(s) you want to assign specific hours</label>
  </div>
  <vc-date-picker v-model="date" mode="datepicker" />
</div> -->

<!-- Modal -->

<!--delete modal end-->

    <!--datepicker modal-->
    <modal ref="datepickerModal">
        <template v-slot:header>
        <h1>Edit Schedule hours</h1>
        </template>

        <template v-slot:body style="height: 273px;background-color:gray">
        <div class="mb-4">

            <date-picker v-model="date" type="date" placeholder="Select date range"></date-picker>
          </div>
          <div class="mb-6">

            <div v-if="newavailabledata[clickdayname].length>0" v-for="(sch, i) in newavailabledata[clickdayname]" :key="i">
                                                <div class="flex gap-2 my-2 items-center" style="width:315px; margin-left: 132px;">
                                                    <vue-timepicker v-model="sch.open" input-class="rounded outline-none" format="HH:mm"></vue-timepicker>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    <vue-timepicker v-model="sch.close" input-class="rounded outline-none" format="HH:mm"></vue-timepicker>


                                                    <a href="javascript:void(0);" @click="removevalue(clickdayname,i)"><i class="fa-solid fa-trash-can" style="margin-left: 10px;"></i></a>
                                                      <a
                                                
                                                href="javascript:void(0);"
                                                @click="
                                                addvalue(
                                                clickdayname,i
                                                )
                                                "
                                                 v-show="
                                                i == 0

                                                "
                                                >
                                                <i class="fa fa-plus"></i>
                                                </a>
                                                  </div>
            </div>

            <div v-if="newavailabledata[clickdayname].length==0">

                  <div class="flex gap-2 my-2 items-center" style="width:315px; margin-left: 216px;">
                                                   <p>Unavailable</p>


                                                    
                                                      <a
                                                
                                                href="javascript:void(0);"
                                                @click="
                                                addvalue(
                                                clickdayname,0
                                                )
                                                "
                                                
                                                >
                                                <i class="fa fa-plus"></i>
                                                </a>
                                                  </div>

            </div>


        

        </div>

        </template>

        <template v-slot:footer>
        <div>
        <button @click="$refs.datepickerModal.closeModal()" class="text-black px-5 py-1 rounded" style="background-color:#e8e9e9;float: left;">Cancel</button>
        <button @click="changeSchedule()" style="float:right" class="bg-red-500 text-white px-5 py-1 rounded">Apply</button>
        </div>
        </template>
    </modal>

    <!--datepicker modal end-->


        
        
      </template>
      <!--  <template v-slot:day-content="{ day, attributes }">
        <div class="flex flex-col is-disabled">
          <span class="day-label text-sm text-gray-900">{{ day.day }}</span>
          <div class="flex-grow overflow-y-auto overflow-x-auto">
            <p
              v-for="attr in attributes"
              :key="attr.key"
              class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1"
              :class="attr.customData.class"
            >
              {{ attr.customData.title }}
            </p>
          </div>
        </div>
      </template> -->
    </vc-calendar>
  </div>
</template>

<script>
//import Modal from "../components/Modal.vue";
import 'v-calendar/src/utils/theme.js'
import moment from "moment";
export default {
  name:"CalendarView",
  props: { availabledata: Object,scheduleid: Number },

  data() {
    const month = new Date().getMonth();
    const year = new Date().getFullYear();
    return {
      date: new Date(2022,2,10),
      timezone: '',
      isClicked:[],
      clickdayname:"",
      newavailabledata:null,
      masks: {
        weekdays: 'WWW',

      },
      weekdays:[{
        1:"sunday",
        2:"monday",
        3:"tuesday",
        4:"wednesday",
        5:"thursday",
        6:"friday",
        7:"saturday",
      }],
        
      attributes: [ 

      {
          key: 'today',
          highlight: true,
          customData: {
            title:'',
            class: ''
          },
          //dates: new Date(),
        },
        // {
        //   key: 1,
        //   customData: {
        //     title: '10:00-11:00',
        //     class: 'bg-red-600 text-white'
        //   },
        //   dates: new Date(year, month, 3),
        // },
        // {
        //   key: 2,
        //   customData: {
        //     title: 'Take Noah to basketball practice',
        //     class: 'bg-blue-500 text-white',
        //   },
        //   dates: new Date(year, month, 2),
        // },
        // {
        //   key: 3,
        //   customData: {
        //     title: "Noah's basketball game.",
        //     class: 'bg-blue-500 text-white',
        //   },
        //   dates: new Date(year, month, 5),
        // },
        // {
        //   key: 4,
        //   customData: {
        //     title: 'Take car to the shop',
        //     class: 'bg-indigo-500 text-white',
        //   },
        //   dates: new Date(year, month, 5),
        // },
        // {
        //   key: 4,
        //   customData: {
        //     title: 'Meeting with new client.',
        //     class: 'bg-teal-500 text-white',
        //   },

        //   dates: new Date(year, month, 7),
        // },
        // {
        //   key: 5,
        //   customData: {
        //     title: "Mia's gymnastics practice.",
        //     class: 'bg-pink-500 text-white',
        //   },
        //   dates: new Date(year, month, 11),
        // },
        // {
        //   key: 6,
        //   customData: {
        //     title: 'Cookout with friends.',
        //     class: 'bg-orange-500 text-white',
        //   },
        //   dates: { months: 5, ordinalWeekdays: { 2: 1 } },
        // },
        // {
        //   key: 7,
        //   customData: {
        //     title: "Mia's gymnastics recital.",
        //     class: 'bg-pink-500 text-white',
        //   },
        //   dates: new Date(year, month, 22),
        // },
        // {
        //   key: 8,
        //   customData: {
        //     title: 'Visit great grandma.',
        //     class: 'bg-red-600 text-white',
        //   },
        //   dates: new Date(year, month, 25),
        // },
      ],
    //   components: {
    //     Modal
      
    // },
    };
  },
  methods: {
     moment(date) {
            return moment(date,'HH:mm').format('hh:mm a');
        },
    dayClicked(day) {
      console.log(day);
      this.newavailabledata = JSON.parse(JSON.stringify(this.availabledata));

      //this.newavailabledata=null;

      //console.log(this.availabledata);
      //console.log(this.newavailabledata);
      var clickyear = day.date.getFullYear();
      var clickmonth = day.date.getMonth();
      var clickday = day.date.getDate();
      var days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
      var dayname = days[day.date.getDay()];
      this.clickdayname = dayname;

      console.log(dayname);

      this.date = new Date(clickyear,clickmonth,clickday);
this.$refs.datepickerModal.openModal();
      //this.isClicked.push(day.day);
      //alert(day.day);
      //this.selectedDay = day;
    },
        addvalue(index,intervalindex) {



            //console.log(index+'--'+intervalindex);
            // let item=index;
             console.log(index);
             console.log(this.newavailabledata);

            //console.log(this.availability.item);
            const prevData=this.newavailabledata[index].slice(-1)[0];

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


            this.newavailabledata[index].push({
                open: prev_start_time,
                close: prev_end_time,

            });
        },
          removevalue(index,intervalindex) {

            //console.log(this.availability[index]);
            this.newavailabledata[index].splice(intervalindex, 1);
            //this.isCheck = false;
        },
        changeSchedule(){

          console.log(this.date);
          console.log(this.scheduleid);

          //this.availabledata = JSON.parse(JSON.stringify(this.newavailabledata));

          console.log(this.newavailabledata);

            this.$axios.post(`/api/schedule`,{

               availability: this.newavailabledata,
                schedule_id: this.scheduleid,
            }).then( res => {

              var newdata = this.newavailabledata;
              //this.availabledata = JSON.parse(JSON.stringify(this.newavailabledata));
              //this.availabledata  = this.newavailabledata;
              this.$refs.datepickerModal.closeModal();
             console.log(res.data);
                 this.$dtoast.pop({
                    preset: "success",
                    heading: `Success!`,
                    content: `Working hours added!`,
                });

                  setTimeout(function () {
                     window.location.reload();
                 }, 1000);

                 //window.location.reload();



            // this.schedules = res.data.data;

            // this.availability = JSON.parse(res.data.data[0].availability);
            // this.schedulename = res.data.data[0].name;
            // this.schedule_name = res.data.data[0].name;
            // this.scheduleId = res.data.data[0].id;
            // this.is_default = res.data.data[0].is_default;
            //this.isActive = true;
            //this.events = res.data.data
        }).catch(() => {
                this.$refs.datepickerModal.closeModal();
                this.$dtoast.pop({
                    preset: "error",
                    heading: `Error!`,
                    content: `Something when wrong, please try again!`,
                });
            });


          // console.log(this.);
        },

  },
};
</script>
<style type="text/css">
  .overflow-hidden {
  overflow: hidden;
}

  .disableclass{
    background-color: #f7f6f6;
    pointer-events: none;
  }
  .currentdate{
    margin-left: 28px;
    width: 30px;
    height: 27px;
    border-radius: 50%;
    color: white;
    background-color: #4d4df5;
    cursor: default;
  }
  :not(.disableclass){

    cursor: pointer;
  }
  .showdate{
    position: absolute;
    top: 102px;
    left: 0;
    z-index: 9999;
    box-shadow: 0 3px 10px rgb(0 0 0 / 20%);
    border-radius: 6px;
  }
  
  /* .custom-calendar.vc-container {
  border: 1px solid #b8c2cc;
  border-highlight: 1px solid #b8c2cc;
  width: 90px;
  height: 90px;
  weekday-bg: #f8fafc;
  weekday-border: 1px solid #eaeaea;
  border-radius: 0;
  width: 100%;
}
  .custom-calendar.vc-container .vc-header {
    background-color: #f1f5f8;
    padding: 10px 0;
  }
  .custom-calendar.vc-container.vc-weeks {
    padding: 0;
  }
  .custom-calendar.vc-container .vc-weekday {
    background-color: var(--weekday-bg);
    border-bottom: var(--weekday-border);
    border-top: var(--weekday-border);
    padding: 5px 0;
  }
  .custom-calendar.vc-container.vc-day {
    padding: 0 5px 3px 5px;
    text-align: left;
    height: var(--day-height);
    min-width: var(--day-width);
    background-color: white;
  }
    .custom-calendar.vc-container.vc-day.weekday-1,
    .custom-calendar.vc-container.vc-day.weekday-7 {
      background-color: #eff8ff;
    }
    .custom-calendar.vc-container.vc-day:not(.on-bottom) {
      border-bottom: var(--day-border);
    }
      .custom-calendar.vc-container.vc-day.weekday-1 {
        border-bottom: var(--day-border-highlight);
      }
    
    .custom-calendar.vc-container.vc-day:not(.on-right) {
      border-right: var(--day-border);
    }
  
  .custom-calendar.vc-day-dots {
    margin-bottom: 5px;
  }*/
</style>


