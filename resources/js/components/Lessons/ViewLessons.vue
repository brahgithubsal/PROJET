<template>
    <AddLessons/>
    <div class="card">
        <DataTable :value="lessons" stripedRows paginator showGridlines :rows="8" dataKey="id" :loading="isLoading">
            <Column header="Image">
                <template #body="{ data }">
                    <img :src="data.image" :alt=data.title class="shadow-4" width="65" />
                </template>
            </Column>
            <Column field="title" header="Titre"></Column>
            <Column field="description" header="Description" sortable></Column>
            <Column field="resources" header="Resources" sortable></Column>
            <Column field="Cours" header="Cours">
                <template #body="{ data }">
                    <ul>
                        <li v-for="course  in getCoursesDATA(data.id)" :key="course.id">
                            {{ course.title }}
                        </li>
                    </ul>
                </template>
            </Column>
            <Column field="id" header="Actions" style="min-width: 12rem">
                <template #body="val">
                    <div class="d-flex">
                        <EditLessons :less="val.data" />
                        <button type="button" class="btn btn-light " @click="deletelesson(val.data.id)"><span
                                style="colrgb(234, 83, 83), 0)"><i class="fa-solid fa-trash"></i></span></button>
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import api from '../config/api.js';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { ref, onMounted } from 'vue';
import AddLessons from './AddLessons.vue';
import EditLessons from './EditLessons.vue';
const lessons = ref([])
const courses = ref([])
const isLoading = ref(true)

const getlessons = async () => {
    await api.get("/api/lessons")
        .then(res => {
            lessons.value = res.data
            isLoading.value = false
        }).catch(error => {
            console.log(error)
        })
}
const getCourses = async () => {
    await api.get("/api/courses")
        .then(res => {
            courses.value = res.data;
        })
        .catch(error => {
            console.log(error);
        });
}
const getCoursesDATA = (course_id) => {
    return courses.value.filter(course => course.course_id === course_id);
}

onMounted(() => {
    getlessons();
    getCourses();
});

const deletelesson = async (id) => {
    if (window.confirm("Etes-vous sûr de vouloir supprimer ?")) {
        try {
            await api.delete(`/api/lessons/${id}`)
            getlessons()
        } catch (error) {
            console.log(error)

        }
    }

}
</script>
<style lang="css" scoped></style>
