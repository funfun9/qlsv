<template>
    <div>
        <h3 class="text-center">Create Student</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addStudent">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="student.name">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" v-model="student.phone">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="student.email">
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" class="form-control" v-model="student.date">
                    </div>
                    <div class="form-group">
                        <label>Score</label>
                        <input type="text" class="form-control" v-model="student.score">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{student:{}}
              },
        created(){
            this.axios.get(`http://localhost:8000/api/student/${this.$route.params.id}`).then((res)=> 
                    {this.student = res.data;});
                 },
        methods:{
            updateStudent(){
                this.axios.patch(`http://localhost:8000/api/student/${this.$route.params.id}`, this.student).then((res)=> 
                {this.$router.push({name: 'home'});});
                           }
                 }
                } 
</script>