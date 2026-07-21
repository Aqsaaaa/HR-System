<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center gap-4">
        <Link :href="route('recruitment.index')" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
          <ArrowLeftIcon class="w-5 h-5" />
        </Link>
        <div>
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ job.title }}</h1>
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ job.position?.name }} &middot; {{ job.location || 'Remote' }}</p>
        </div>
        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full" :class="statusClass(job.status)">
          {{ job.status }}
        </span>
      </div>

      <!-- Summary -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Applicants</span>
          <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ job.applications_count || 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Slots</span>
          <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ job.slots }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Salary</span>
          <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ formatCurrency(job.salary_min) }} - {{ formatCurrency(job.salary_max) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <span class="text-xs text-gray-500 dark:text-gray-400">Type</span>
          <p class="text-2xl font-bold text-gray-900 dark:text-white capitalize">{{ job.type?.replace('_', ' ') }}</p>
        </div>
      </div>

      <!-- Description -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Description</h2>
        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ job.description }}</p>
      </div>

      <!-- Pipeline -->
      <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-800">
          <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Candidates Pipeline</h2>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Candidate</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Email</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Stage</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Applied</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
              <tr v-for="app in job.applications" :key="app.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ app.candidate?.first_name }} {{ app.candidate?.last_name }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ app.candidate?.email }}</td>
                <td class="px-4 py-3">
                  <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full" :class="stageClass(app.stage)">
                    {{ app.stage }}
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ app.applied_at }}</td>
                <td class="px-4 py-3">
                  <button @click="moveStage(app.candidate_id, 'interview')" v-if="app.stage === 'applied'"
                    class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 mr-3">Interview</button>
                  <button @click="sendOffer(app.candidate_id)" v-if="app.stage === 'interview'"
                    class="text-xs text-green-600 hover:text-green-800 dark:text-green-400">Offer</button>
                </td>
              </tr>
              <tr v-if="!job.applications?.length">
                <td colspan="5" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">No candidates yet</td>
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
  job: { type: Object, required: true },
})

function formatCurrency(val) {
  if (!val && val !== 0) return '-'
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val)
}

function statusClass(status) {
  const map = {
    draft: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
    published: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    closed: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}

function stageClass(stage) {
  const map = {
    applied: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
    screening: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    interview: 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
    offer: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    hired: 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
    rejected: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
  }
  return map[stage] || 'bg-gray-100 text-gray-700'
}

function moveStage(candidateId, stage) {
  router.post(route('api.recruitment.candidates.stage', candidateId), { stage }, {
    preserveScroll: true,
  })
}

function sendOffer(candidateId) {
  router.post(route('api.recruitment.candidates.offer', candidateId), {}, {
    preserveScroll: true,
  })
}
</script>
