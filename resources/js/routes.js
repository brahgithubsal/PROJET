import Accueil from './components/accueil.vue';
import ViewLessons from "./components/Lessons/ViewLessons.vue"
import ViewCategory from "./components/Category/ViewCategory.vue"
import ViewCours from "./components/Courses/ViewCours.vue"
import Cart from './components/Cart/Cart.vue';
import LstCours from './components/Cart/LstCours.vue';
export const routes = [
    {
        name: 'accueil',
        path: '/',
        component: Accueil
    },
    {
        name: 'ViewLessons',
        path: '/ViewLessons',
        component: ViewLessons
    },
    {
        name: 'ViewCategory',
        path: '/ViewCategory',
        component: ViewCategory
    }
    ,
    {
        name: 'ViewCours',
        path: '/ViewCours',
        component: ViewCours
    },
    {
        path: '/cart',
        name: 'Cart',
        component: Cart
    },
    {
        path: '/LstCours',
        name: 'LstCours',
        component: LstCours
    },
];
