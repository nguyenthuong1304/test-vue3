<template>
  <div class="overflow-hidden overflow-x-auto min-w-full align-middle sm:rounded-md">
    <div class="flex place-content-end mb-4">
      <div class="px-4 py-2 text-white bg-indigo-600 hover:bg-indigo-700 cursor-pointer">
        <router-link :to="{ name: 'companies.create' }" class="text-sm font-medium">Create company</router-link>
      </div>
    </div>
    <div class="flex place-content-end mb-4">
      <div class="flex-1 py-1 px-2">
        <input
          type="text"
          name="name"
          id="name"
          placeholder="Search company name"
          class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          v-model="params.name"
        >
      </div>
      <div class="flex-1 py-1 px-2">
        <input
          type="text"
          name="email"
          id="email"
          placeholder="Search company email"
          class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          v-model="params.code"
        >
      </div>
      <div class="flex-1 py-1 px-2">
        <input
          type="date"
          name="address"
          id="address"
          placeholder="Search company address"
          class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          v-model="params.founding_date"
        >
      </div>
      <div class="py-1 px-2">
        <button
          type="button"
          name="email"
          id="search"
          class="bg-purple-500 text-white active:bg-purple-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none ease-linear transition-all duration-150"
          @click.prevent="search"
        >
          Search
        </button>
      </div>
    </div>
    <div class="flex mb-4">
      <div class="py-1 px-2">
        <input
          type="date"
          name="f"
          id="from"
          placeholder="Search company website"
          class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          v-model="params.created_from"
        >
      </div>
      <div class="py-1 px-2">
        <input
          type="date"
          name="website"
          id="to"
          placeholder="Search company website"
          class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          v-model="params.created_to"
        >
      </div>
    </div>
    <table class="min-w-full border divide-y divide-gray-200">
      <thead>
      <tr>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">Tên công ty</span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">Mã công ty</span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">Ngày thành lập</span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">Số nhân viên</span>
        </th>
        <th class="px-6 py-3 bg-gray-50">
          <span class="text-xs font-medium tracking-wider leading-4 text-left text-gray-500 uppercase">image</span>
        </th>
        <th class="px-6 py-3 bg-gray-50"></th>
      </tr>
      </thead>

      <tbody class="bg-white divide-y divide-gray-200 divide-solid">
      <template v-for="item in companies" :key="item.id">
        <tr class="bg-white">
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.name }}
          </td>
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.code }}
          </td>
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.founding_date }}
          </td>
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.users_count }}
          </td>
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            {{ item.image }}
          </td>
          <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
            <router-link :to="{ name: 'companies.edit', params: { id: item.id } }"
                         class="mr-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
              Edit
            </router-link>
            <button @click="deleteCompany(item.id)"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
              Delete
            </button>
          </td>
        </tr>
      </template>
      </tbody>
      <tfoot class="min-w-full border divide-y divide-gray-200">
        <Pagination
          :total="params.total"
          :current="params.current"
          :perPage="params.perPage"
          @page-changed="handleChangePage"
        />
      </tfoot>
    </table>

  </div>
</template>
<script>
import Pagination from "../base/Pagination";
import useCompanies from "../../composables/companies";
import { onMounted, reactive } from "vue";

export default {
  components: {
    Pagination
  },
  name: "CompanyIndex",
  setup() {
    const { companies, getCompanies, destroyCompany } = useCompanies()

    const params = reactive({
      'name': '',
      'code': '',
      'founding_date': '',
      'created_from': null,
      'created_to': null,
      'total' : 0,
      'current': 1,
      'perPage': 5,
    })

    const search = async (page = 1) => {
      let { total, perPage, ...paramsSearch } = params
      await getCompanies({
        ...paramsSearch,
        page: typeof page === 'number' ? page : params.current,
      })
      params.total = companies.meta.total;
      params.perPage = companies.meta.per_page;
      params.current = typeof page === 'number' ? page : params.current;
    }
    onMounted(search)

    const deleteCompany = async (id) => {
      if (!window.confirm('Are you sure?')) {
        return
      }
      await destroyCompany(id);
      await getCompanies();
    }

    const handleChangePage = ($event) => {
      search($event)
    }

    return {
      companies,
      deleteCompany,
      search,
      params,
      handleChangePage
    }
  }
}
</script>
