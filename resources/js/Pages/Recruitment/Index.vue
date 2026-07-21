<template>
  <AppLayout>
    <div class="space-y-6">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Recruitment</h1>
        <button @click="showCreateJob = true"
          class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
          <PlusIcon class="w-4 h-4" />
          New Job
        </button>
      </div>

      <!-- Pipeline -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="job in jobs.data" :key="job.id"
          class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-4">
          <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ job.title }}</h3>
            <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full" :class="statusClass(job.status)">
              {{ job.status }}
            </span>
          </div>
          <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ job.position?.name }}</p>
          <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <span>{{ job.applications_count || 0 }} applicants</span>
            <Link :href="route('recruitment.show', job.id)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">View</Link>
          </div>
        </div>
        <div v-if="!jobs.data?.length"
          class="col-span-full bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-8 text-center text-gray-500 dark:text-gray-400">
          No job postings yet
        </div>
      </div>

      <!-- Create Job Modal -->
      <div v-if="showCreateJob" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="showCreateJob = false">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl border border-gray-200 dark:border-gray-800 w-full max-w-2xl mx-4 p-6 max-h-[90vh] overflow-y-auto">
          <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Create Job Posting</h3>
          <form @submit.prevent="createJob" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
              <input v-model="jobForm.title" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Position</label>
              <select v-model="jobForm.position_id" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                <option value="">Select position</option>
                <option v-for="pos in positions" :key="pos.id" :value="pos.id">{{ pos.name }}</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
              <textarea v-model="jobForm.description" rows="3" required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white"></textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Requirements</label>
              <textarea v-model="jobForm.requirements" rows="3"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Salary</label>
                <input v-model.number="jobForm.salary_min" type="number"
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Salary</label>
                <input v-model.number="jobForm.salary_max" type="number"
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                <input v-model="jobForm.location"
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                <select v-model="jobForm.type"
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                  <option value="full_time">Full Time</option>
                  <option value="part_time">Part Time</option>
                  <option value="contract">Contract</option>
                  <option value="internship">Internship</option>
                </select>
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slots</label>
              <input v-model.number="jobForm.slots" type="number" min="1"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white" />
            </div>
            <div class="flex justify-end gap-3 mt-6">
              <button type="button" @click="showCreateJob = false"
                class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">Cancel</button>
              <button type="submit" :disabled="creating"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-50">
                {{ creating ? 'Creating...' : 'Create Job' }}
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
  jobs: { type: Object, default: () => ({ data: [] }) },
  positions: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
})

const showCreateJob = ref(false)
const creating = ref(false)
const jobForm = ref({
  title: '',
  position_id: '',
  description: '',
  requirements: '',
  salary_min: null,
  salary_max: null,
  location: '',
  type: 'full_time',
  slots: 1,
})

function statusClass(status) {
  const map = {
    draft: 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
    published: 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    closed: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
  }
  return map[status] || 'bg-gray-100 text-gray-700'
}

function createJob() {
  creating.value = true
  router.post(route('api.recruitment.jobs.store'), jobForm.value, {
    preserveState: true,
    onSuccess: () => {
      showCreateJob.value = false
      jobForm.value = { title: '', position_id: '', description: '', requirements: '', salary_min: null, salary_max: null, location: '', type: 'full_time', slots: 1 }
    },
    onFinish: () => { creating.value = false },
  })
}
</script>
