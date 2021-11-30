import { ref } from 'vue'
import axios from "axios";
import { useRouter } from 'vue-router';

export default function useCompanies() {
  const companies = ref([])
  const company = ref([])
  const router = useRouter()
  const errors = ref('')

  const getCompanies = async (params = {}) => {
    console.log(params)
    let response = await axios.get('/api/v1/companies', {
      params
    })
    companies.value = response.data.data;
  }

  const getCompany = async (id) => {
    let response = await axios.get('/api/v1/companies/' + id)
    company.value = response.data.data;
  }

  const storeCompany = async (data) => {
    errors.value = ''
    try {
      await axios.post('/api/v1/companies/', data)
      await router.push({name: 'companies.index'})
    } catch (e) {
      if (e.response.status === 422) {
        for (const key in e.response.data.errors) {
          errors.value += e.response.data.errors[key][0] + ' ';
        }
      }
    }
  }

  const updateCompany = async (id) => {
    errors.value = ''
    try {
      await axios.put('/api/v1/companies/' + id, company.value)
      await router.push({name: 'companies.index'})
    } catch (e) {
      if (e.response.status === 422) {
        for (const key in e.response.data.errors) {
          errors.value += e.response.data.errors[key][0] + ' ';
        }
      }
    }
  }

  const destroyCompany = async (id) => {
    await axios.delete('/api/v1/companies/' + id)
  }


  return {
    companies,
    company,
    errors,
    getCompanies,
    getCompany,
    storeCompany,
    updateCompany,
    destroyCompany
  }
}
