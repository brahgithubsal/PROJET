<template>
    <AddCategory />
    <div class="card">
        <DataTable :value="categories" stripedRows paginator showGridlines :rows="8" dataKey="id" :loading="isLoading">
            <Column header="Image">
                <template #body="{ data }">
                    <img :src="data.image" :alt=data.name class="shadow-4" width="65" />
                </template>
            </Column>
            <Column field="name" header="Nom"></Column>
            <Column field="description" header="Description" sortable></Column>
            <Column field="id" header="Actions" style="min-width: 12rem">
                <template #body="val">
                    <div class="d-flex">
                        <EditCategory :cat="val.data" />
                        <button type="button" class="btn btn-light " @click="deleteCategorie(val.data.id)"><span
                        style="color: rgb(255, 106, 106)"><i class="fa-solid fa-trash"></i></span></button>
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
import AddCategory from './AddCategory.vue';
import EditCategory from './EditCategory.vue';
const categories = ref([])
const isLoading = ref(true)

const getCategories = async () => {
    await api.get("/api/categories")
        .then(res => {
            categories.value = res.data
            isLoading.value = false
        }).catch(error => {
            console.log(error)
        })
}
onMounted(() => {
    getCategories();
});

const deleteCategorie = async (id) => {
    if (window.confirm("Etes-vous sûr de vouloir supprimer ?")) {
        try {
            await api.delete(`/api/categories/${id}`)
           getCategories()
        } catch (error) {
            console.log(error)

        }
    }

}
</script>
<style lang="css" scoped></style>
