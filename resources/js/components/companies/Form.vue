<template>
  <div class="mt-2 mb-6 text-sm text-red-600" v-if="errors !== ''">
    {{ errors }}
  </div>

  <form class="space-y-6" @submit.prevent="saveCompany">
    <div class="space-y-4 rounded-md shadow-sm">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Tên công ty</label>
        <div class="mt-1">
          <input type="text" name="name" id="name"
           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
           v-model="form.name">
        </div>
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Mã công ty</label>
        <div class="mt-1">
          <input type="text" name="email" id="email"
           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
           v-model="form.code">
        </div>
      </div>

      <div>
        <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
        <div class="mt-1">
          <input type="text" name="address" id="address"
           class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
           v-model="form.address">
        </div>
      </div>

      <div>
        <label for="founding_date" class="block text-sm font-medium text-gray-700">Ngày thành lập</label>
        <div class="mt-1">
          <input type="date" name="founding_date" id="founding_date"
                 class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                 v-model="form.founding_date">
        </div>
      </div>

      <div>
        <label for="image" class="block text-sm font-medium text-gray-700">Ảnh</label>
        <div class="mt-1">
          <input type="text" name="image" id="image"
                 class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                 v-model="form.image" disabled>
        </div>
      </div>

      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
        <div class="mt-1">
          <textarea type="text" name="description" id="description"
             class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
             v-model="form.description"></textarea>
        </div>
      </div>
    </div>

    <button type="submit"
      class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent ring-gray-300 transition duration-150 ease-in-out hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
      {{ companyId ? 'Update' : 'Create' }}
    </button>
  </form>
</template>

<script>
import { reactive, onMounted } from "vue"
import useCompanies from "../../composables/companies";

export default {
  name: "Form",
  props: {
    companyId: {
      required: false,
      type: String
    },
  },

  setup(props) {
    let form = reactive({
      'id': null,
      'name': null,
      'code': null,
      'description': null,
      'address': null,
      'image': null,
      'founding_date': null,
    })

    const { errors, company, getCompany, updateCompany, storeCompany } = useCompanies()

    if (props.companyId) {
      onMounted(getCompany(props.companyId))
      form = company;
    }

    const saveCompany = async () => {
      props.companyId
        ? await updateCompany(props.companyId)
        : await storeCompany({ ...form })
    }

    return {
      form,
      saveCompany,
      errors
    }
  }
}
</script>

