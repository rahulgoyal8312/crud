<template>
	<div>
		<div class="card text-center mb-3">
			<div class="card-header"><h2>Phonebook</h2></div>
			<div class="card-body">
				<form class="mb-2" @submit.prevent="addPerson">
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" name="name" class="form-control" placeholder="Enter name" v-model="person.name">
					</div>
					<div class="form-group">
						<label for="name">Phone:</label>
						<input type="text" name="phone" class="form-control" placeholder="Enter Phone number" v-model="person.phone">
					</div>
					<div class="form-group">
						<label for="name">Address:</label>
						<input type="text" name="address" class="form-control" placeholder="Enter Address" v-model="person.address">
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-info">Add</button>
						<button type="reset" class="btn btn-danger">Reset</button>
					</div>
				</form>
			</div>
		</div>
		<div>
		<div>
			<table class="table table-striped">
				<thead>
					<tr>
						<td>Id</td>
						<td>Name</td>
						<td>Phone</td>
						<td>Action</td>
					</tr>
				</thead>
				<tr v-for="person in persons" v-bind:key="person.id">
					<td>{{person.id}}</td>
					<td>{{person.name}}</td>
					<td>{{person.phone}}</td>
					<td>
						<view-person href="#" id="show-modal" @click="showModal=true; setVal(person)" class="fa fa-eye mr-sm-1"></view-person>
						<a href="#" @click="editPerson(person)"	class="fa fa-pencil mr-sm-1"></a>
						<a href="#" @click="deletePerson(person.id)" class="fa fa-trash"></a>
					</td>
				</tr>
			</table>
		</div>	
		</div>
	</div>
</template>

<script>
	import viewperson from './View.vue';
	export default{
		data() {
			return {
				persons: [],
				person: {
					id: '',
					name: '',
					address: '',
					phone: ''
				},
				person_id: '',
				edit: false,
				pagination: {},
				showModal: false
			}
		},

		created() {
			this.fetchPersons();
		},

		methods: {
			fetchPersons(){
				fetch('api/persons')
					.then(res => res.json())
					.then(res => {
						this.persons = res.data;
					})
					.catch(err => console.log(err));
			},

			addPerson() {
				if(this.edit===false){
					fetch('api/person',{
						method: 'post',
						body: JSON.stringify(this.person),
						headers: {
							'content-type': 'application/json'
						}
					})
					.then(res => res.json())
					.then(data => {
						this.person.name='';
						this.person.phone='';
						this.person.address='';
						alert('Person Added');
						this.fetchPersons();
					})
		    		.catch(err => console.log(err));
				}
				else{
					fetch('api/person',{
						method: 'put',
						body: JSON.stringify(this.person),
						headers: {
							'content-type': 'application/json'
						}
					})
					.then(res => res.json())
					.then(data => {
						this.person.name='';
						this.person.phone='';
						this.person.address='';
						alert('Person Updated');
						this.fetchPersons();
					})
		    		.catch(err => console.log(err));
				}
			},

			editPerson(person) {
				this.edit=true,
				this.person.id=person.id;
				this.person.person_id=person.id;
				this.person.name=person.name;
				this.person.address=person.address;
				this.person.phone=person.phone;
			},

			deletePerson(id) {
				if(confirm('Are you sure?')) {
					fetch(`api/person/${id}`,{
						method: 'delete'
					})
					.then(res => res.json())
					.then(data => {
						alert('Person Details Removed!');
						this.fetchPersons();
					})
					.catch(err => console.log(err));
				}
			},

			setVal(person) {
				this.person.id=person.id;
				this.person.name=person.name;
				this.person.phone=person.phone;
				this.person.address=person.address;
			}
		}
	}
</script>