<template>
    <div class="drag">
        <div v-if="isLoading">
        </div>
        <div v-else class="row">
            <div class="col-md-12" style="display:flex;flex-wrap:wrap;justify-content:center">
                <div class="card" style="width: 18rem;margin:6px" v-for="cours in courses" :key="cours.id">
                    <img :src="cours.image" :alt=cours.title class="w-100" height="300">
                    <div class="card-body">
                        <div style="text-align:center">
                            <b class="card-title">{{ cours.title }}</b>
                            <p class="card-text">{{ cours.description.substr(0, 80) }}</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Prix : {{ cours.price }} TND</li>
                            </ul>
                            <button class="btn btn-outline-primary" @click="addToCart(prod)" v-if="cours.nbcopy > 1">Add to Cart</button>
                            <button class="btn btn-default" v-if="cours.nbcopy <= 1">OUT OFSOLD</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import store from '../../store'
import api from '../config/api.js';
import { ref, onMounted, computed } from 'vue';
const courses = ref([]);
const isLoading = ref(true)
onMounted(() => {
    getcourses();
});

const getcourses = () => {

    api.get('/api/courses').then(res => {
         courses.value = res.data;
        isLoading.value = false
    }).catch(error => {
        console.log(error)
    });

}

const addToCart = (cours) => {
    store.commit("Articlestore/addCart", { product: cours, qty: 1 });

}

</script>
<style scoped>
.drag {
    margin-top: 70px;
}
</style>
