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
                            <label for="Categories" class="form-label">Categorie</label>
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
                    <button type="submit" className="btn btn-outline-success" @click="modifiercour">
                        <i class="fa-solid fa-floppy-disk"></i>Modifier</button>
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
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
// Create FilePond component
const FilePond = vueFilePond(FilePondPluginImagePreview);
const myFiles = ref([]);
import axios from 'axios';
const props = defineProps(['cours'])
const visible = ref(false);
const course = ref({})
const categories = ref([]);
const courses = ref([]);
const getcourses = async () => {
    await api.get("/api/courses")
        .then(res => {
            courses.value = res.data
            //   isLoading.value = false
        }).catch(error => {
            console.log(error)
        })
}
const handleFilePondInit = async () => {
    if (course.value.image) {

        myFiles.value = [
            {
                source: course.value.image,
                options: { type: 'local' }
            }
        ]
    }
}
const getCategories = async () => {
    await api.get("/api/categories")
        .then(res => {
            categories.value = res.data
            isLoading.value = false
        }).catch(error => {
            console.log(error)
        })
}
const getCategoryName = (categoryId) => {
    const category = categories.value.find((cat) => cat.id === categoryId);
    return category ? category.name : 'Unknown Category';
};
const loadcourse = () => {

    course.value = props.cours
}
onMounted(() => {
    getcourses()
    loadcourse()
    getCategories()
}
);
const errors = ref([]);
const modifiercour = async () => {
    try {
        // Clear previous errors
        errors.value = [];

        // Make the API call to update the producer
        await api.put(`/api/courses/${course.value.id}`, course.value);

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


const cancel = () => {
    visible.value = false

}
const serverOptions = () => {
    console.log('server pond');
    return {
        load: (source, load, error, progress, abort, headers) => {
            var myRequest = new Request(source);
            fetch(myRequest).then(function (response) {
                response.blob().then(function (myBlob) {
                    load(myBlob);
                });
            });
        },
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

                    course.value.image = data.url;
                    load(data);
                })
                .catch((error) => {
                    console.error('Error uploading file:', error);
                    error('Upload failed');
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
