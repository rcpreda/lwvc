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
					<div class="w-full max-w-lg">
						<div class="flex flex-wrap -mx-3 mb-6 gap-2" style="margin-left: 25px;">

						<div id="preview" class="rounded-full bg-gray-200" style="width:90px;height: 90px;overflow: hidden;">
						<img v-if="url" :src="url" />
						</div>
						<div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
							<div class="flex justify-center">
							<div class="mb-3 w-96">
							<label for="formFile" class="form-label inline-block mb-2 text-gray-700">Profile Image</label>
							<input class="form-control
							block
							w-full
							px-3
							py-1.5
							text-base
							font-normal
							text-gray-700
							bg-white bg-clip-padding
							border border-solid border-gray-300
							rounded
							transition
							ease-in-out
							m-0
							focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" accept="image/png,image/gif,image/jpeg" type="file" id="formFile" @change="onFileChange" ref="file">
							</div>

							</div>
							<p>JPG, GIF or PNG</p>
							
						</div>	

						<div class="w-full px-3 -mx-3 mb-6 md:mb-0">
						<label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
						Name
						</label>
						<input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Full Name" v-model="fullname">
						<!-- <p class="text-red-500 text-xs italic">Please fill out this field.</p> -->
						</div>
					<!-- 	<div class="w-full md:w-1/2 px-3">
						<label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
						Last Name
						</label>
						<input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Doe">
						</div> -->

						<div class="w-full px-3 -mx-3 mb-6 md:mb-0">
						<label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
						Email
						</label>
						<input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight" type="text" v-model="authDetails.email" :readonly="true">
						<!-- <p class="text-red-500 text-xs italic">Please fill out this field.</p> -->
						</div>
						</div>
						<!-- <div class="flex flex-wrap -mx-3 mb-6">
						<div class="w-full px-3">
						<label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
						Password
						</label>
						<input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-password" type="password" placeholder="******************">
						<p class="text-gray-600 text-xs italic">Make it as long and as crazy as you'd like</p>
						</div>
						</div> -->
			<!-- 			<div class="flex flex-wrap -mx-3 mb-2">
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
						</div> -->

						<button @click="updateProfile" class="bg-blue-500 hover:bg-blue-700 text-white font-bold mt-5 py-2 px-4 rounded-full">
					Save Changes
					</button>
					</div>
			        
			    </div>
			    <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
			      <p>
			       	Changing your URL will mean that all of your copied links will no longer work and will need to be updated.</p>
			        <br />
			        <label>{{hostname}}/<input class="shadow appearance-none border rounded w-52 ml-2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" v-on:keyup="checkAvailable" id="link" v-model="newlink" type="text" placeholder="link" :class="{'border-red-500' : validationErrorMessages.newlink !== null, 'border-green-500' : successMessages.newlink !== null}" 
			        	></label>
			        <small class="text-red-500 mx-2" v-show="validationErrorMessages.newlink !== null">{{ validationErrorMessages.newlink }}</small>
			        <small class="text-green-500 mx-2" v-show="successMessages.newlink !== null">{{ successMessages.newlink }}</small>
			        <br />
			        
			     
					<button @click="updateLink" class="bg-blue-500 hover:bg-blue-700 text-white font-bold mt-5 py-2 px-4 rounded-full">
					Save Changes
					</button>
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
           hostname:null,
           newlink:"",
           linkProcess:false,
           url: null,
           profileImage:null,
           fullname:null,
           authDetails:{},
           validationErrorMessages: {
            
            newlink: null,
            
           },
            successMessages: {
            
            newlink: null,
            
           },
        }
    },
    components: {
        Navbar,
        
      
    },
    methods: {

		toggleTabs: function(tabNumber){
		this.openTab = tabNumber
		},
		checkAvailable(){

			if(this.newlink!=""){

				this.$axios.get(`/api/checkavailable/${this.newlink}`).then( res => {

				if(res.data.success==true){

					this.validationErrorMessages.newlink = "Link not available";
					this.successMessages.newlink = null;

				}else{

					this.successMessages.newlink = "Available";
					this.validationErrorMessages.newlink = null;

				}

			});
			}else{

				this.successMessages.newlink = null;
				this.validationErrorMessages.newlink = null;
				


			}

			

		},
		updateLink(){

			this.linkProcess = true;

			if(this.newlink==""){

				 this.validationErrorMessages.newlink = "Please fill out this field.";
				 this.linkProcess = false;


			}else{
				this.validationErrorMessages.newlink = null;
				this.linkProcess = true;
			}

			if(this.linkProcess==true){
			var userData = JSON.parse(localStorage.getItem('auth-user'));
				this.$axios.get(`/api/updatelink/${userData.id}/${this.newlink}`).then( res => {

				// let userData = JSON.parse(localStorage.getItem('auth-user'));

				if(res.data.success==true){

					userData.username =  this.newlink;
					localStorage.setItem('auth-user', JSON.stringify(userData));
					console.log(res);

					 this.$dtoast.pop({
                        preset: "success",
                        heading: `Success!`,
                        content: `Link updated`,
                        });

				}else{

					   this.$dtoast.pop({
                        preset: "error",
                        heading: `Error!`,
                        content: `User not match`,
                        });
				}
				

				});
			}

			


		},
		onFileChange(e) {
		const file = e.target.files[0];

		console.log(e.target.files[0]['type']);
		// if(e.target.files[0]['type']!='image/jpeg' || e.target.files[0]['type']!='image/png' || e.target.files[0]['type']!='image/gif'){

		// 		this.$dtoast.pop({
  //                       preset: "error",
  //                       heading: `Error!`,
  //                       content: `Image type not match`,
  //                       });


		// }else{

			this.profileImage = e.target.files[0];
			this.url = URL.createObjectURL(file);

		// }
		
		},
		updateProfile() {
			const formData = new FormData();
			formData.append('file', this.profileImage);
			formData.append('name', this.fullname);
			const headers = { 'Content-Type': 'multipart/form-data' };
			axios.post('/api/updateProfile', formData, { headers }).then((res) => {
				
				console.log(res);
			});
      	}



    },
    mounted() {

    	  this.hostname = window.location.host;
    	  var userData = JSON.parse(localStorage.getItem('auth-user'));

    	  this.authDetails = userData;
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

