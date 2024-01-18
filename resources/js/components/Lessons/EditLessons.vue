<template>
    <button type="button" class="btn btn-primary" @click="visible = true">
        <span style="color: rgb(255, 255, 255)">
            <i class="fa-solid fa-pen-to-square"></i>
        </span>
    </button>
    <form>
        <div class="card flex justify-content-center">
             <Dialog v-model:visible="visible">
                    <div class="row custom-row">
                        <div class="col-md-6 ms-auto">
                            <label for="title" class="form-label">Lesson</label>

                            <input type="text" class="form-control" id="title" v-model="lessons.title">

                        </div>
                        <div class="col-md-6 ms-auto">
                            <label for="description" class="form-label">Description</label>

                            <textarea class="form-control" id="description" v-model="lessons.description"></textarea>
                        </div>
                        <div class="col-md-6 ms-auto">
                            <label for="Courses" class="form-label">Cours</label>
                            <select class="form-control" v-model="lessons.course_id">
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
                    <button type="submit" className="btn btn-outline-success" @click="modifierlessons">
                        <i class="fa-solid fa-floppy-disk"></i> Modifier</button>
                    &nbsp
                    <button type="button" className="btn btn-outline-danger" @click="cancel">
                        <i class="fa-solid fa-floppy-disk"></i> Annuler </button>
                </Dialog>
        </div>
    </form>
</template>

<script setup>
import api from '../config/api.js';
import { ref, onMounted } from "vue"
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import Dialog from 'primevue/dialog';
import axios from 'axios';
const props = defineProps(['less'])
const visible = ref(false);
const lessons = ref({})

const courses = ref([]);
const getlessons = async () => {
    await api.get("/api/lessons")
        .then(res => {
            lessons.value = res.data
            //   isLoading.value = false
        }).catch(error => {
            console.log(error)
        })
}


const loadlessons = () => {

    lessons.value = props.less
}
onMounted(() => {
    getlessons()
    loadlessons()
    getCourses()
}
);
const errors = ref([]);
const modifierlessons= async () => {
    try {
        // Clear previous errors
        errors.value = [];

        // Make the API call to update the producer
        await api.put(`/api/lessons/${lessons.value.id}`, lessons.value);

        // Optionally, you may want to handle the successful update here
        visible.value = false;
    } catch (error) {
        // Handle validation errors
        if (error.response && error.response.status === 422) {
            errors.value = Object.values(error.response.data.errors).flat();
        } else {
            console.error("There was an error!", error);
        }
    }
};
const getCourses = async () => {
    try {
        const response = await api.get("/api/courses");
        courses.value = response.data;
        isLoading.value = false;
    } catch (error) {
        console.error("Error fetching courses:", error);
    }
};

const getCourseTitle = (courseId) => {
    const course = courses.value.find((c) => c.id === courseId);
    console.log("Course data for lesson with ID", courseId);
    return course ? course.title : "Unknown"; // Return the title of the course or "Unknown" if not found
};


const cancel = () => {
    visible.value = false

}

</script>
<style scoped></style>
