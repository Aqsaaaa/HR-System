<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center gap-4">
        <Link :href="route('performance.index')" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
          <ArrowLeftIcon class="w-5 h-5" />
        </Link>
        <div>
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ cycle.name }}</h1>
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ cycle.start_date }} - {{ cycle.end_date }}</p>
        </div>
        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full" :class="statusClass(cycle.status)">
          {{ cycle.status }}
        </span>
        <button v-if="cycle.status === 'draft'" @click="launchCycle"
          class="ml-auto px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
          Launch
        </button>
      </div>

      <div v-if="cycle.description" class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
        <p class="text-sm text-gray-700 dark:text-gray-300">{{ cycle.description }}</p>
      </div>

      <!-- Goals -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Goals</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Employee</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Title</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Progress</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Due</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              <tr v-for="goal in cycle.goals" :key="goal.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ goal.employee?.first_name }} {{ goal.employee?.last_name }}</td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ goal.title }}</td>
                <td class="px-4 py-3">
                  <div class="flex items-center gap-2">
                    <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                      <div class="h-full rounded-full transition-all" :style="{ width: goal.progress + '%', backgroundColor: progressColor(goal.progress) }"></div>
                    </div>
                    <span class="text-xs text-gray-500">{{ goal.progress }}%</span>
                  </div>
                </td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full" :class="goalStatusClass(goal.status)">
                    {{ goal.status }}
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ goal.due_date }}</td>
              </tr>
              <tr v-if="!cycle.goals?.length">
                <td colspan="5" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">No goals</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Reviews -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Reviews</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Employee</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Rating</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Submitted</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              <tr v-for="review in cycle.reviews" :key="review.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ review.employee?.first_name }} {{ review.employee?.last_name }}</td>
                <td class="px-4 py-3">
                  <span class="text-sm font-bold" :class="ratingClass(review.rating)">{{ review.rating || '-' }}</span>
                </td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full" :class="reviewStatusClass(review.status)">
                    {{ review.status }}
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ review.submitted_at || '-' }}</td>
              </tr>
              <tr v-if="!cycle.reviews?.length">
                <td colspan="4" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">No reviews</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  cycle: { type: Object, required: true },
})

function statusClass(status) {
  const map = {
    draft: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
    active: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    completed: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}

function goalStatusClass(status) {
  const map = {
    draft: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
    active: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
    completed: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}

function reviewStatusClass(status) {
  const map = {
    draft: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
    submitted: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    completed: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}

function progressColor(val) {
  if (val >= 100) return '#22c55e'
  if (val >= 50) return '#3b82f6'
  return '#f59e0b'
}

function ratingClass(val) {
  if (!val) return 'text-gray-400'
  if (val >= 80) return 'text-green-600'
  if (val >= 60) return 'text-blue-600'
  return 'text-yellow-600'
}

function launchCycle() {
  fetch(route('api.performance.cycles.launch', props.cycle.id), {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
  }).then(() => {
    router.reload({ preserveScroll: true })
  })
}
</script>
