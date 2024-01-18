import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate';
import Articlestore from './modules/CourseFeature'
export default createStore({
    modules: {
        Articlestore

    },
    plugins: [createPersistedState()],
})
