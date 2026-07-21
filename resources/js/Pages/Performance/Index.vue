<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Performance</h1>
        <button @click="showCreate = true"
          class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
          <PlusIcon class="w-4 h-4" />
          New Cycle
        </button>
      </div>

      <!-- Cycles -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="cycle in cycles.data" :key="cycle.id"
          class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ cycle.name }}</h3>
            <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full" :class="statusClass(cycle.status)">
              {{ cycle.status }}
            </span>
          </div>
          <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ cycle.start_date }} - {{ cycle.end_date }}</p>
          <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <span>{{ cycle.reviews_count || 0 }} reviews</span>
            <Link :href="route('performance.show', cycle.id)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">View</Link>
          </div>
        </div>
        <div v-if="!cycles.data?.length"
          class="col-span-full bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-8 text-center text-gray-500 dark:text-gray-400">
          No performance cycles yet
        </div>
      </div>

      <!-- Create Modal -->
      <div v-if="showCreate" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="showCreate = false">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl border border-gray-200 dark:border-gray-800 w-full max-w-lg mx-4 p-6">
          <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Create Performance Cycle</h3>
          <form @submit.prevent="createCycle" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
              <input v-model="form.name" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                <input v-model="form.start_date" type="date" required
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                <input v-model="form.end_date" type="date" required
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
              <textarea v-model="form.description" rows="3"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white"></textarea>
            </div>
            <div class="flex justify-end gap-3 mt-6">
              <button type="button" @click="showCreate = false"
                class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">Cancel</button>
              <button type="submit" :disabled="creating"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-50">
                {{ creating ? 'Creating...' : 'Create' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { PlusIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  cycles: { type: Object, default: () => ({ data: [] }) },
  employees: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
})

const showCreate = ref(false)
const creating = ref(false)
const form = ref({ name: '', start_date: '', end_date: '', description: '' })

function statusClass(status) {
  const map = {
    draft: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
    active: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    completed: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}

function createCycle() {
  creating.value = true
  fetch(route('api.cycles.store'), {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    body: JSON.stringify(form.value),
  }).then(() => {
    showCreate.value = false
    form.value = { name: '', start_date: '', end_date: '', description: '' }
    router.reload({ preserveScroll: true })
  }).finally(() => { creating.value = false })
}
</script>
