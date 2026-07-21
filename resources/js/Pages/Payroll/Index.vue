<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Payroll</h1>
        <button @click="showCreateRun = true"
          class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
          <PlusIcon class="w-4 h-4" />
          New Payroll Run
        </button>
      </div>

      <!-- Latest Run Summary -->
      <div v-if="latestRun" class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">{{ latestRun.name }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div>
            <span class="text-xs text-gray-500 dark:text-gray-400">Employees</span>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ latestRun.total_employees }}</p>
          </div>
          <div>
            <span class="text-xs text-gray-500 dark:text-gray-400">Total Gross</span>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ formatCurrency(latestRun.total_gross) }}</p>
          </div>
          <div>
            <span class="text-xs text-gray-500 dark:text-gray-400">Total Deductions</span>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ formatCurrency(latestRun.total_deductions) }}</p>
          </div>
          <div>
            <span class="text-xs text-gray-500 dark:text-gray-400">Total Net Pay</span>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ formatCurrency(latestRun.total_net) }}</p>
          </div>
        </div>
      </div>

      <!-- Components -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Payroll Components</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Code</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Name</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Type</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Calculation</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Default Value</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              <tr v-for="comp in components" :key="comp.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-4 py-3 text-sm font-mono text-gray-700 dark:text-gray-300">{{ comp.code }}</td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ comp.name }}</td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full"
                    :class="comp.type === 'earning' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400'">
                    {{ comp.type }}
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ comp.calculation_type }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ formatCurrency(comp.default_value) }}</td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full"
                    :class="comp.is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400'">
                    {{ comp.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
              </tr>
              <tr v-if="!components.length">
                <td colspan="6" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">No components configured</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Payroll Runs -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Payroll History</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Name</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Period</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Employees</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Net Pay</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              <tr v-for="run in runs.data" :key="run.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ run.name }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ run.period_start }} - {{ run.period_end }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ run.total_employees }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ formatCurrency(run.total_net) }}</td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full" :class="statusClass(run.status)">
                    {{ run.status }}
                  </span>
                </td>
                <td class="px-4 py-3">
                  <button @click="processRun(run.id)" v-if="run.status === 'draft'"
                    class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 mr-3">Process</button>
                  <button @click="viewPayslips(run.id)"
                    class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400">View</button>
                </td>
              </tr>
              <tr v-if="!runs.data?.length">
                <td colspan="6" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">No payroll runs yet</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Create Run Modal -->
      <div v-if="showCreateRun" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="showCreateRun = false">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl border border-gray-200 dark:border-gray-800 w-full max-w-lg mx-4 p-6">
          <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">New Payroll Run</h3>
          <form @submit.prevent="createRun" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
              <input v-model="form.name" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Month</label>
                <select v-model.number="form.month" required
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                  <option v-for="m in 12" :key="m" :value="m">{{ monthName(m) }}</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year</label>
                <input v-model.number="form.year" type="number" required min="2020" max="2099"
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Period Start</label>
                <input v-model="form.period_start" type="date" required
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Period End</label>
                <input v-model="form.period_end" type="date" required
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
              </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
              <button type="button" @click="showCreateRun = false"
                class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">Cancel</button>
              <button type="submit" :disabled="creating"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-50">
                {{ creating ? 'Creating...' : 'Create Run' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { PlusIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  runs: { type: Object, default: () => ({ data: [] }) },
  components: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
})

const latestRun = computed(() => props.runs.data?.length ? props.runs.data[0] : null)

const showCreateRun = ref(false)
const creating = ref(false)
const form = ref({
  name: '',
  month: new Date().getMonth() + 1,
  year: new Date().getFullYear(),
  period_start: '',
  period_end: '',
})

function monthName(m) {
  return new Date(2000, m - 1, 1).toLocaleString('default', { month: 'long' })
}

function formatCurrency(val) {
  if (!val && val !== 0) return '-'
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val)
}

function statusClass(status) {
  const map = {
    draft: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
    processing: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    completed: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    cancelled: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}

function createRun() {
  creating.value = true
  router.post(route('api.payroll.runs.store'), form.value, {
    preserveState: true,
    onSuccess: () => {
      showCreateRun.value = false
      form.value = { name: '', month: new Date().getMonth() + 1, year: new Date().getFullYear(), period_start: '', period_end: '' }
    },
    onFinish: () => { creating.value = false },
  })
}

function processRun(id) {
  router.post(route('api.payroll.runs.process', id), {}, {
    preserveScroll: true,
  })
}

function viewPayslips(id) {
  router.get(route('api.payroll.runs.payslips', id))
}
</script>
