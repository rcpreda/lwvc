<template>
  <div class="text-center section">
    <h2 class="h2">Working Calendars</h2>
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

         <div @click='dayClicked(day)' class="flex flex-col h-full z-10 overflow-hidden" v-bind:class="{ 'disableclass' : new Date(day.id)<new Date((new Date()).valueOf() - 1000*60*60*24)}" style="padding: 20px;">
          <span  v-bind:class="{ 'currentdate' : day.isToday==true}" style="margin-bottom: 5px;" >{{ day.day}}</span>
           <div class="flex-grow overflow-y-auto overflow-x-auto">

            <div  v-for="(item, i) in availabledata" :key="i" style="font-size:11px;">
              <p v-if="weekdays[0][day.weekday]==i" v-for="(times, j) in availabledata[i]" :key="j">
                
                  {{times.open+'-'+times.close }}
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
import 'v-calendar/src/utils/theme.js'
export default {
  name:"CalendarView",
  props: { availabledata: Object },

  data() {
    const month = new Date().getMonth();
    const year = new Date().getFullYear();
    return {
      date: new Date(),
      timezone: '',
      isClicked:[],
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
    };
  },
  methods: {
    dayClicked(day) {
      console.log(day);

      this.isClicked.push(day.day);
      //alert(day.day);
      //this.selectedDay = day;
    },
  },
};
</script>
<style type="text/css">

  .disableclass{
    background-color: #f7f6f6;
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


