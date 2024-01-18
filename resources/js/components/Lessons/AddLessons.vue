<template>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <button type="button" class="btn btn-primary" @click="visible = true">
                <span style="color: rgb(255, 255, 255)">
                    <i class="fa-solid fa-square-plus"> </i>
                </span>
                Ajouter Une Lesson
            </button>
        </div>
    </nav>
    <form @submit.prevent="addLesson">
        <div class="card flex content-center">
            <Dialog v-model:visible="visible">
                <div class="row custom-row">
                    <div class="col-md-6 ms-auto">
                        <label for="title" class="form-label">Lesson</label>

                        <input type="text" class="form-control" id="title" v-model="lesson.title">

                    </div>
                    <div class="col-md-6 ms-auto">
                        <label for="description" class="form-label">Description</label>

                        <textarea class="form-control" id="description" v-model="lesson.description"></textarea>
                    </div>
                    <div class="col-md-6 ms-auto">
                        <label for="Courses" class="form-label">Cours</label>
                        <select class="form-control" v-model="lesson.course_id">
                            <option v-for="cours in courses" :key="cours.id" :value=cours.id>{{ cours.title }}
                            </option>
                        </select>
                    </div>
                </div>
                <div v-if="errors.length" class="alert alert-danger">
                    <ul>
                        <li v-for="error in errors" :key="error">{{ error }}</li>
                    </ul>
                </div>
                <hr>
                <button type="submit" className="btn btn-outline-success" @click="addLesson">
                    <i class="fa-solid fa-floppy-disk"></i> Ajouter</button>
                &nbsp
                <button type="button" className="btn btn-outline-danger" @click="cancel">
                    <i class="fa-solid fa-floppy-disk"></i> Annuler </button>
            </Dialog>
        </div>
    </form>
</template>

<script setup>
import { ref, onMounted } from "vue"
import api from '../config/api.js';
import Dialog from 'primevue/dialog';
import axios from "axios";
const visible = ref(false);
const lesson = ref({
    title: "",
    description: "",
    resources: "",
    course_id: "",// Array to hold selected actor IDs
});

const errors = ref([]);
const courses = ref([]);
const getcourses = () => {

    api.get('/api/courses').then(res => {
        courses.value = res.data;
    }).catch(error => {
        console.log(error)
    });

}
const cancel = () => {
    visible.value = false
}
const addLesson = async () => {
    try {

        errors.value = [];

        // Créez d'abord le film
        const response = await api.post("/api/lessons/", lesson.value);
        const filmId = response.data.id; // Obtenez l'ID du film créé

        // Ensuite, attachez les acteurs au film s'ils sont sélectionnés
        if (film.value.acteurIDs.length > 0) {
            await api.post(`/api/films/${filmId}/add-acteurs`, {
                acteurIDs: film.value.acteurIDs,
            });
        }

        visible.value = false;
        window.location.reload();
    } catch (error) {
        // Gérer les erreurs ici
    }
};

onMounted(() => {
  getcourses()
});

</script>
<style scoped>
.custom-row {
    /* Set a specific height for the row */
    height: auto;
    width: 600px;
    /* Adjust the height as needed */
    /* Add any other custom styles for the row */
}
</style>

