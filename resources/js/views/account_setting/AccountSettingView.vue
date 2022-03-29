<template>
   	<div>
        <Navbar/>
        <div class="w-full bg-white border-t shadow-lg">
            <div class="flex gap-10 max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                <span class="py-4 text-lg">Account Setting</span>
            </div>
        </div>

		<div class="max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
			<div class="flex">
			<ul class="mb-0 flex-wrap list-none pt-3 pb-4 flex-col w-52">
				<li class="-mb-px mr-2 flex-auto text-center">
				  <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal" v-on:click="toggleTabs(1)" v-bind:class="{'text-sky-600 bg-white': openTab !== 1, 'text-white bg-sky-600': openTab === 1}">
				    Profile
				  </a>
				</li>
				<li class="-mb-px mr-2 flex-auto text-center">
				  <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal" v-on:click="toggleTabs(2)" v-bind:class="{'text-sky-600 bg-white': openTab !== 2, 'text-white bg-sky-600': openTab === 2}">
				    My Link
				  </a>
				</li>
				<li class="-mb-px mr-2 flex-auto text-center">
				  <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal" v-on:click="toggleTabs(3)" v-bind:class="{'text-sky-600 bg-white': openTab !== 3, 'text-white bg-sky-600': openTab === 3}">
				    Other
				  </a>
				</li>
			</ul>
			<div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 mt-3 shadow-lg rounded">
			<div class="px-4 py-5 flex-auto">
			  <div class="tab-content tab-space">
			    <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
			      <p>
			      Profile</p>
			        <br />
			        <form class="w-full max-w-lg">
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
        First Name
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Jane">
      <p class="text-red-500 text-xs italic">Please fill out this field.</p>
    </div>
    <div class="w-full md:w-1/2 px-3">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
        Last Name
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Doe">
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full px-3">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
        Password
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="password" placeholder="******************">
      <p class="text-gray-600 text-xs italic">Make it as long and as crazy as you'd like</p>
    </div>
  </div>
  <div class="flex flex-wrap -mx-3 mb-2">
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
        City
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-city" type="text" placeholder="Albuquerque">
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
        State
      </label>
      <div class="relative">
        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
          <option>New Mexico</option>
          <option>Missouri</option>
          <option>Texas</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
      </div>
    </div>
    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
        Zip
      </label>
      <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-zip" type="text" placeholder="90210">
    </div>
  </div>
</form>
			        
			    </div>
			    <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
			      <p>
			       	Changing your Calendly URL will mean that all of your copied links will no longer work and will need to be updated.
			        <br />
			        <label>{{hostname}}/<input class="shadow appearance-none border rounded w-52 ml-2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="link" type="text" placeholder="link"></label>
			        <br />
			        
			      </p>
			      <button></button>
			    </div>
			    <div v-bind:class="{'hidden': openTab !== 3, 'block': openTab === 3}">
			      <p>
			        Efficiently unleash cross-media information without
			        cross-media value. Quickly maximize timely deliverables for
			        real-time schemas.
			        <br />
			        <br />
			        Dramatically maintain clicks-and-mortar solutions
			        without functional solutions.
			      </p>
			    </div>
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
	name:"AccountSettingView",
    data(){
        return { 
           openTab: 1,
           hostname:null
        }
    },
    components: {
        Navbar,
        
      
    },
    methods: {

		toggleTabs: function(tabNumber){
		this.openTab = tabNumber
		}

    },
    mounted() {

    	  this.hostname = window.location.host;
        // this.$axios.get(`/api/schedule`).then( res => {

        //     console.log(res.data.data);

        //     this.schedules = res.data.data;

        //     this.availability = JSON.parse(res.data.data[0].availability);
        //     this.schedulename = res.data.data[0].name;
        //     this.schedule_name = res.data.data[0].name;
        //     this.scheduleId = res.data.data[0].id;
        //     this.is_default = res.data.data[0].is_default;
        //     //this.isActive = true;
        //     //this.events = res.data.data
        // })
    },
}
</script>

