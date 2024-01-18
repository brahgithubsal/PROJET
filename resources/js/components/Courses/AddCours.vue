<template>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <button type="button" class="btn btn-primary" @click="visible = true">
                <span style="color: rgb(255, 255, 255)">
                    <i class="fa-solid fa-square-plus"> </i>
                </span>
                Ajouter Cours
            </button>
        </div>
    </nav>
    <form @submit.prevent="AddCourse">
        <div class="card flex content-center">
            <Dialog v-model:visible="visible">
                <div class="row custom-row">
                    <div class="col-md-6 ms-auto">
                        <label for="title" class="form-label">Titre</label>

                        <input type="text" class="form-control" id="title" v-model="cours.title">

                    </div>
                    <div class="col-md-6 ms-auto">
                        <label for="description" class="form-label">Description</label>

                        <textarea class="form-control" id="description" v-model="cours.description"></textarea>
                    </div>
                    <div class="col-md-6 ms-auto">
                            <label for="level" class="form-label">level</label>

                            <input type="text" class="form-control" id="level" v-model="cours.level">

                        </div>
                        <div class="col-md-6 ms-auto">
                                    <label for="duration" class="form-label">Duration</label>

                                    <input type="text" class="form-control" id="duration" v-model="cours.duration">

                                </div>
                         <div class="col-md-6 ms-auto">
                                <label for="price" class="form-label">prix</label>

                                <input type="text" class="form-control" id="price" v-model="cours.price">

                            </div>
                            <div class="col-md-6 ms-auto">
                                    <label for="nbcopy" class="form-label">Nombre De copies</label>

                                    <input type="text" class="form-control" id="nbcopy" v-model="cours.nbcopy">

                                </div>
                    <div class="col-md-6 ms-auto">
                        <label for="Producers" class="form-label">Categorie</label>
                        <select class="form-control" v-model="cours.category_id">
                            <option v-for="cat in categories" :key="cat.id" :value=cat.id>{{ cat.name }}
                            </option>
                        </select>
                    </div>
                </div>
                 <hr>
                        <div class="row">
                            <file-pond name="test" ref="pond" class-name="my-pond" label-idle="Déposer les fichiers ici..."
                                allow-multiple="false" accepted-file-types="image/jpeg, image/png" v-bind:files="myFiles"
                                :server="serverOptions()" />
                        </div>

                        <hr>
                <div v-if="errors.length" class="alert alert-danger">
                    <ul>
                        <li v-for="error in errors" :key="error">{{ error }}</li>
                    </ul>
                </div>
                <hr>
                <button type="submit" className="btn btn-outline-success" @click="AddCourse">
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
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

// Create FilePond component
const FilePond = vueFilePond(FilePondPluginImagePreview);
const visible = ref(false);
const cours = ref({
    title: "",
    description: "",
    image: "/img/img1",
    duration: "",
    level: "",
    price: "",
    nbcopy: "",
    category_id: "",
    // Array to hold selected actor IDs
});

const errors = ref([]);
const categories = ref([]);
const getCategories = async () => {
    await api.get("/api/categories")
        .then(res => {
            categories.value = res.data
            isLoading.value = false
        }).catch(error => {
            console.log(error)
        })
}
const cancel = () => {
    visible.value = false
}
const handleFilePondInit = () => {
    console.log('FilePond has initialized');
}
onMounted(() => {
    getCategories()
});
const AddCourse = async () => {
    try {
        // Clear previous errors
        errors.value = [];

        // Your existing code for adding a producer
        await api.post("/api/courses/", cours.value);
        visible.value = false;
        window.location.reload();
    }   catch (error) {
        if (error.response && error.response.status === 422) {
            console.log("Validation errors:", error.response.data.errors);
            errors.value = Object.values(error.response.data.errors).flat();
            console.log(cours.value)
        } else {
            console.error("Error in AddCourse:", error);
        }
    }
};


const serverOptions = () => {
    console.log('server pond');
    return {
        process: (fieldName, file, metadata, load, error, progress, abort) => {
            const data = new FormData();
            data.append('file', file);
            data.append('upload_preset', 'GLID5IIT');
            data.append('cloud_name', 'esps');
            data.append('public_id', file.name);
            axios.post('https://api.cloudinary.com/v1_1/esps/upload', data)
                .then((response) => response.data)
                .then((data) => {
                    console.log(data);

                    cours.value.image = data.url;
                    load(data);
                })
                .catch((error) => {
                    console.error('Erreur de téléchargement du fichier :', error);
                    error('Erreur de téléchargement du fichier ');
                    abort();
                });
        },
    };
};
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

