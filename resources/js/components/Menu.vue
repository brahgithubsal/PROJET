<template>
   <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Allemni</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor04" aria-controls="navbarColor04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarColor04">
        <ul class="navbar-nav me-auto">
           <li class="nav-item">
                 <router-link class="nav-link active" to="/">Page d'accueil</router-link>
               </li>

                <li class="nav-item">
                     <router-link class="nav-link active" to="/ViewLessons">Liste Lessons</router-link>
                   </li>
                    <li class="nav-item">
                       <router-link class="nav-link active" to="/ViewCategory">Liste Catégories</router-link>
                     </li>
                      <li class="nav-item">
                         <router-link class="nav-link active" to="/ViewCours">Liste Cours</router-link>
                       </li>
                       <li class="nav-item">
                             <router-link class="nav-link active" to="/LstCours">Les Cours Disponibles</router-link>
                           </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-sm-2" type="search" placeholder="Search">
          <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
    <li class="nav-item me-3">
    <router-link class="nav-link position-relative" :class="$route.name == 'Cart' ? 'active' : ''" aria-current="page" :to="{name: 'Cart'}">
    <i class="fa-solid fa-cart-shopping fa-lg" style="color:#000000;"></i>
    <span v-if="$store.state.Articlestore.cart.length > 0" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
    {{ $store.state.Articlestore.cart.length }}
    </span>
    </router-link>
    </li>
    </ul>
      </div>
    </div>
  </nav>
 </template>

 <script setup>

 </script>

 <style lang="scss" scoped></style>
