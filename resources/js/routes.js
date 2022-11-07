import liststudents from './components/list-students.vue';
import createstudent from './components/create-student.vue';
import editstudent from './components/edit-student.vue';

export const routes = [{
    name: 'home',
    path: '/',
    component: liststudents
},
{
    name: 'create',
    path: '/create',
    component: createstudent
},
{
    name: 'edit',
    path: '/edit/:id',
    component: editstudent
}
];