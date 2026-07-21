<template>
  <AppLayout>
    <div class="space-y-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Audit Log</h1>

      <!-- Filters -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
        <form @submit.prevent="applyFilters" class="flex flex-wrap gap-3 items-end">
          <div>
            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Module</label>
            <select v-model="filters.module" class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-1.5 text-sm">
              <option value="">All</option>
              <option v-for="m in modules" :key="m" :value="m">{{ m }}</option>
            </select>
          </div>
          <div>
            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Action</label>
            <select v-model="filters.action" class="rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-1.5 text-sm">
              <option value="">All</option>
              <option v-for="a in actions" :key="a" :value="a">{{ a }}</option>
            </select>
          </div>
          <div class="flex-1 min-w-[200px]">
            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Search</label>
            <input v-model="filters.search" type="text" placeholder="user, event, subject..."
              class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-white px-3 py-1.5 text-sm" />
          </div>
          <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Filter</button>
          <button type="button" @click="clearFilters" class="px-3 py-1.5 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Clear</button>
        </form>
      </div>

      <!-- Logs Table -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800/50">
              <tr>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Time</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">User</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Module</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Action</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Event</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Subject</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">IP</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              <tr v-for="log in logs.data" :key="log.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/30">
                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ timeAgo(log.created_at) }}</td>
                <td class="px-4 py-3 text-gray-900 dark:text-white whitespace-nowrap">{{ log.user_name || '-' }}</td>
                <td class="px-4 py-3">
                  <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 capitalize">{{ log.module }}</span>
                </td>
                <td class="px-4 py-3">
                  <span class="px-2 py-0.5 text-xs rounded-full" :class="actionBadge(log.action)">{{ log.action }}</span>
                </td>
                <td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400 font-mono">{{ log.event }}</td>
                <td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400">{{ log.subject_description || '-' }}</td>
                <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400 font-mono">{{ log.ip_address || '-' }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-if="!logs.data.length" class="text-center py-12 text-sm text-gray-500 dark:text-gray-400">
          No audit logs found.
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="logs.last_page > 1" class="flex justify-center gap-2">
        <Link v-for="page in logs.last_page" :key="page" :href="logs.path + '?page=' + page"
          class="px-3 py-1 text-sm rounded-lg"
          :class="page === logs.current_page ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700'">
          {{ page }}
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  logs: { type: Object, required: true },
  modules: { type: Array, default: () => [] },
  actions: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
})

const filters = reactive({
  module: props.filters.module || '',
  action: props.filters.action || '',
  search: props.filters.search || '',
})

function applyFilters() {
  router.get(route('audit-logs.index'), filters, { preserveState: true })
}

function clearFilters() {
  filters.module = ''
  filters.action = ''
  filters.search = ''
  router.get(route('audit-logs.index'), {}, { preserveState: true })
}

function timeAgo(date) {
  const diff = Date.now() - new Date(date).getTime()
  const mins = Math.floor(diff / 60000)
  if (mins < 1) return 'just now'
  if (mins < 60) return mins + 'm ago'
  const hrs = Math.floor(mins / 60)
  if (hrs < 24) return hrs + 'h ago'
  return Math.floor(hrs / 24) + 'd ago'
}

function actionBadge(action) {
  const colors = {
    create: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
    update: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
    delete: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
  }
  return colors[action] || 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300'
}
</script>
