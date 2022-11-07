<template>
    <div>
        <h2 class="text-center">Students List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="student in students" key="product.id">
                    <td>{{student.id}}</td>
                    <td>{{student.name}}</td>
                    <td>{{student.phone}}</td>
                    <td>{{student.email}}</td>
                    <td>{{student.date}}</td>
                    <td>{{student.score}}</td>

                    <td>
                        <div class="btn-group" role="group">
                            <router-link: to="{name: 'edit', params: {id: student.id}}" class="btn btn-success">Edit</router-link:>
                            <button class="btn btn-danger" @click="deleteStudent(student.id)">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default{
       data(){
          return{students:[]}
        },
       created(){
            this.axios.get('http://localhost:8000/api/students/').then(response => {
                this.students = response.data;
             });
        },
       methods:{
           deleteStudent(id){
                this.axios.delete('http://localhost:8000/api/student/${id}').then(response =>{
                    let i=this.student.map(data=>data.id).indexOf(id);
                    this.student.splice(i, 1)
                });
            }
        }
    } 
</script>