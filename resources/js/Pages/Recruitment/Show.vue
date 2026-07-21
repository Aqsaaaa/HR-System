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
          <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ job.applications?.length || 0 }}</p>
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
                  <button @click="openStageModal(app)" v-if="app.stage === 'applied' || app.stage === 'screening'"
                    class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 mr-3">Interview</button>
                  <button @click="openStageModal(app)" v-if="app.stage === 'interview'"
                    class="text-xs text-green-600 hover:text-green-800 dark:text-green-400 mr-3">Offer</button>
                  <button @click="openStageModal(app)" v-if="app.stage !== 'hired' && app.stage !== 'rejected'"
                    class="text-xs text-red-600 hover:text-red-800 dark:text-red-400">Reject</button>
                </td>
              </tr>
              <tr v-if="!job.applications?.length">
                <td colspan="5" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">No candidates yet</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Stage Modal -->
      <div v-if="selectedApp" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="selectedApp = null">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl border border-gray-200 dark:border-gray-800 w-full max-w-md mx-4 p-6">
          <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Update Stage</h3>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ selectedApp.candidate?.first_name }} {{ selectedApp.candidate?.last_name }}</p>
          <form @submit.prevent="updateStage" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stage</label>
              <select v-model="stageForm.stage" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                <option value="screening">Screening</option>
                <option value="interview">Interview</option>
                <option value="offer">Offer</option>
                <option value="hired">Hired</option>
                <option value="rejected">Rejected</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
              <textarea v-model="stageForm.notes" rows="3"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white"></textarea>
            </div>
            <div class="flex justify-end gap-3">
              <button type="button" @click="selectedApp = null"
                class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">Cancel</button>
              <button type="submit" :disabled="submitting"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-50">
                {{ submitting ? 'Updating...' : 'Update' }}
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
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  job: { type: Object, required: true },
})

const selectedApp = ref(null)
const submitting = ref(false)
const stageForm = ref({ stage: 'screening', notes: '' })

function openStageModal(app) {
  const nextStages = { applied: 'screening', screening: 'interview', interview: 'offer', offer: 'hired' }
  stageForm.value = { stage: nextStages[app.stage] || app.stage, notes: '' }
  selectedApp.value = app
}

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

function updateStage() {
  submitting.value = true
  fetch(route('api.recruitment.candidates.stage', selectedApp.value.candidate_id), {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    body: JSON.stringify(stageForm.value),
  }).then(() => {
    selectedApp.value = null
    router.reload({ preserveScroll: true })
  }).finally(() => { submitting.value = false })
}
</script>
