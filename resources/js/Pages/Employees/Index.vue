<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Employees</h1>
        <Link :href="route('employees.create')"
          class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
          <PlusIcon class="w-4 h-4" />
          Add Employee
        </Link>
      </div>

      <!-- Filters -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
        <div class="flex flex-wrap items-center gap-4">
          <div class="flex-1 min-w-[200px]">
            <input v-model="search" @input="debouncedSearch" type="text" placeholder="Search by name, email, employee ID..."
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" />
          </div>
          <select v-model="filters.department_id" @change="fetchData"
            class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">All Departments</option>
            <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
          </select>
          <select v-model="filters.employment_status" @change="fetchData"
            class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="terminated">Terminated</option>
            <option value="resigned">Resigned</option>
          </select>
        </div>
      </div>

      <!-- Table -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Department</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Position</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hire Date</th>
                <th class="text-right px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              <tr v-for="emp in employees.data" :key="emp.id"
                class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <td class="px-4 py-3">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 text-sm font-medium flex-shrink-0">
                      {{ emp.first_name.charAt(0) }}{{ emp.last_name.charAt(0) }}
                    </div>
                    <div>
                      <Link :href="route('employees.show', emp.id)" class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                        {{ emp.first_name }} {{ emp.last_name }}
                      </Link>
                      <p class="text-xs text-gray-500 dark:text-gray-400">{{ emp.employee_id }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ emp.department?.name || '-' }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ emp.position?.name || '-' }}</td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full"
                    :class="statusClass(emp.employment_status)">
                    {{ emp.employment_status }}
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ formatDate(emp.hire_date) }}</td>
                <td class="px-4 py-3 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <Link :href="route('employees.show', emp.id)"
                      class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                      <EyeIcon class="w-4 h-4" />
                    </Link>
                    <Link :href="route('employees.edit', emp.id)"
                      class="p-1.5 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                      <PencilIcon class="w-4 h-4" />
                    </Link>
                    <button @click="confirmDelete(emp)"
                      class="p-1.5 text-gray-400 hover:text-red-600 dark:hover:text-red-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                      <TrashIcon class="w-4 h-4" />
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="!employees.data?.length">
                <td colspan="6" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">No employees found</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="employees.total > employees.per_page" class="flex items-center justify-between px-4 py-3 border-t border-gray-200 dark:border-gray-800">
          <p class="text-sm text-gray-500 dark:text-gray-400">
            Showing {{ employees.from }} to {{ employees.to }} of {{ employees.total }}
          </p>
          <div class="flex items-center gap-2">
            <button @click="prevPage" :disabled="!employees.prev_page_url"
              class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-700 rounded-lg disabled:opacity-50 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
              Previous
            </button>
            <button @click="nextPage" :disabled="!employees.next_page_url"
              class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-700 rounded-lg disabled:opacity-50 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
              Next
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="fixed inset-0 bg-black/50" @click="showDeleteModal = false" />
      <div class="relative bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Employee</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
          Are you sure you want to delete {{ deleting?.first_name }} {{ deleting?.last_name }}? This action can be reversed by an administrator.
        </p>
        <div class="flex justify-end gap-3">
          <button @click="showDeleteModal = false"
            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
            Cancel
          </button>
          <button @click="deleteEmployee"
            class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
            Delete
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { formatDate } from '@/utils/date'
import { PlusIcon, EyeIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  employees: { type: Object, default: () => ({ data: [], total: 0, from: 0, to: 0, per_page: 15, prev_page_url: null, next_page_url: null }) },
  filters: { type: Object, default: () => ({}) },
})

const departments = ref([])
const search = ref('')
const filters = reactive({
  department_id: props.filters.department_id || '',
  employment_status: props.filters.employment_status || '',
})
const showDeleteModal = ref(false)
const deleting = ref(null)

let debounceTimer = null
function debouncedSearch() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(fetchData, 300)
}

function fetchData() {
  router.get('/employees', { search: search.value, ...filters }, { preserveState: true, replace: true })
}

function prevPage() {
  if (props.employees.prev_page_url) {
    router.get(props.employees.prev_page_url, {}, { preserveState: true, replace: true })
  }
}

function nextPage() {
  if (props.employees.next_page_url) {
    router.get(props.employees.next_page_url, {}, { preserveState: true, replace: true })
  }
}

function confirmDelete(emp) {
  deleting.value = emp
  showDeleteModal.value = true
}

function deleteEmployee() {
  if (!deleting.value) return
  router.delete(`/api/v1/employees/${deleting.value.id}`, {
    preserveState: true,
    onSuccess: () => {
      showDeleteModal.value = false
      deleting.value = null
      fetchData()
    },
  })
}

function statusClass(status) {
  const map = {
    active: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    inactive: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
    terminated: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
    resigned: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    suspended: 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}

onMounted(async () => {
  const res = await fetch('/api/v1/departments')
  const json = await res.json()
  departments.value = json.data || []
})
</script>
