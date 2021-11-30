require('./bootstrap');
import { createApp } from "vue";
import router from './router'
import CompanyIndex from './components/companies/CompanyIndex'

createApp({
    components: {
        CompanyIndex
    }
}).use(router).mount('#app')
