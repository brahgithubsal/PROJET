<template>
    <AddCours/>
    <div class="card">
        <DataTable :value="courses" stripedRows paginator showGridlines :rows="8" dataKey="id" :loading="isLoading">
          <Column header="Image">
                    <template #body="{ data }">
                        <img :src="data.image" :alt=data.title class="shadow-4" width="65" />
                    </template>
                </Column>
            <Column field="title" header="Titre"></Column>
            <Column field="description" header="Description" sortable></Column>
            <Column field="duration" header="Duration"></Column>
            <Column field="price" header="Prix"></Column>
            <Column field="category" header="Catégorie">
                <template #body="{ data }">
                {{ getCategoryName(data.category_id) }}
                </template>
            </Column>
            <Column field="id" header="Actions" style="min-width: 12rem">
            <template #body="val">
            <div class="d-flex">
            <EditCours :cours="val.data" />
            <button type="button" class="btn btn-light " @click="deletecourse(val.data.id)"><span style="color: rgb(255, 106, 106)"><i class="fa-solid fa-trash"></i></span></button>
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
import AddCours from './AddCours.vue';
import EditCours from './EditCours.vue';
const categories = ref([]);
const courses = ref([]);
const isLoading = ref(true);

const getCourses = async () => {
    try {
        const response = await api.get("/api/courses");
        courses.value = response.data;
        isLoading.value = false;
    } catch (error) {
        console.error("Error fetching courses:", error);
    }
};

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
const deletecourse = async (id) => {
    if (window.confirm("Etes-vous sûr de vouloir supprimer ?")) {
        try {
            await api.delete(`/api/courses/${id}`)
            getCourses()
        } catch (error) {
            console.log(error)

        }
    }

}
onMounted(() => {
    getCategories();
    getCourses();
});
</script>

<style lang="css" scoped>
/* Add any required styles here */
</style>
